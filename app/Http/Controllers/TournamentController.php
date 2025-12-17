<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Tournament;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTournamentRequest;
use App\Models\Team;
use App\Models\Scheidsrechter;
use App\Models\School;
use App\Models\User;
use App\Http\Requests\UpdateTournamentRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::all();
        return view('tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        $all = $this->getAllData();
        return view('tournaments.createTournament', compact('all'));
    }

    public function store(StoreTournamentRequest $request)
    {
        //VALIDATIE 
        $data = $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'sport' => 'required|in:voetbal,lijnbal',
            'group' => 'required|in:groep3/4,groep5/6,groep7/8,klas1_jongens,klas1_meiden',
            'startTime' => 'required|date_format:H:i',
            'teamsPerPool' => 'required|integer|min:2',
        ]);

        // Controleer of de toernooinaam al bestaat
        if (Tournament::where('name', $data['name'])->exists()) {
            return redirect()->back()->withErrors([
                'name' => 'Er bestaat al een toernooi met deze naam.'
            ])->withInput();
        }

        // INSTELLINGEN
        // Spelinstellingen per sport en leeftijdsgroep

        $gameSettings = [
            'voetbal' => [
                'groep3/4' => ['fields' => 4, 'length' => 15, 'pause' => 5],
                'groep5/6' => ['fields' => 8, 'length' => 15, 'pause' => 5],
                'groep7/8' => ['fields' => 8, 'length' => 15, 'pause' => 5],
                'klas1_meiden' => ['fields' => 4, 'length' => 15, 'pause' => 5],
                'klas1_jongens' => ['fields' => 3, 'length' => 15, 'pause' => 5],
            ],
            'lijnbal' => [
                'groep3/4' => ['fields' => 4, 'length' => 10, 'pause' => 2],
                'groep5/6' => ['fields' => 4, 'length' => 10, 'pause' => 2],
                'groep7/8' => ['fields' => 4, 'length' => 10, 'pause' => 2],
                'klas1_meiden' => ['fields' => 4, 'length' => 12, 'pause' => 0],
                'klas1_jongens' => ['fields' => 4, 'length' => 12, 'pause' => 0],
            ]
        ];

        // TEAMS OPHALEN 
        // Haal alle beschikbare teams op die nog geen toernooi hebben
        $teams = Team::where('sport', $data['sport'])
            ->where('group', $data['group'])
            ->whereNull('tournament_id')
            ->get()
            ->shuffle();

        $teamsPerPool = $data['teamsPerPool'];
        $teamCount = $teams->count();

        // Controle: genoeg teams?
        if ($teamCount < $teamsPerPool) {
            return redirect()->back()->withErrors([
                'team' => 'Niet genoeg teams beschikbaar.'
            ])->withInput();
        }

        // Controle: voorkom een poule met slechts 1 team
        if ($teamCount % $teamsPerPool === 1) {
            return redirect()->back()->withErrors([
                'team' => 'Er blijft 1 team over dat alleen in een poule zou zitten.'
            ])->withInput();
        }

        // POULES MAKEN
        // Groepeer teams per school
        $teamsBySchool = $teams->groupBy('school_id');

        // Bepaal aantal poules
        $pouleCount = (int) ceil($teamCount / $teamsPerPool);
        $poules = array_fill(0, $pouleCount, []);

        // Verdeel teams over poules, gespreid per school
        $index = 0;
        foreach ($teamsBySchool as $schoolTeams) {
            if ($schoolTeams->count() > $pouleCount) {
                return redirect()->back()->withErrors([
                    'team' => 'Te veel teams van dezelfde school.'
                ])->withInput();
            }

            foreach ($schoolTeams as $team) {
                $poules[$index % $pouleCount][] = $team;
                $index++;
            }
        }

        //TOERNOOI MAKEN
        $fields = $gameSettings[$data['sport']][$data['group']]['fields'];

        $tournament = Tournament::create([
            'name' => $data['name'],
            'date' => $data['date'],
            'start_time' => $data['startTime'],
            'fields_amount' => $fields,
            'game_length_minutes' => $gameSettings[$data['sport']][$data['group']]['length'],
            'amount_teams_pool' => $teamsPerPool,
            'archived' => false,
        ]);

        //TEAMS OPSLAAN
        // Zet teams vast in het toernooi en wijs poules toe
        $teams = collect($poules)->flatten();

        foreach ($teams->values() as $i => $team) {
            $team->update([
                'pool' => floor($i / $teamsPerPool) + 1,
                'tournament_id' => $tournament->id,
            ]);
        }

        //FIXTURES VERZAMELEN 
        // Groepeer teams per poule
        $teamsByPool = $teams->groupBy('pool');
        $fixturesToCreate = [];

        foreach ($teamsByPool as $pool => $poolTeams) {
            $poolTeams = $poolTeams->values();

            for ($i = 0; $i < $poolTeams->count(); $i++) {
                for ($j = $i + 1; $j < $poolTeams->count(); $j++) {
                    $fixturesToCreate[] = [
                        'team1' => $poolTeams[$i],
                        'team2' => $poolTeams[$j],
                    ];
                }
            }
        }

        //PLANNING TIJD + VELDEN
        $currentTime = Carbon::createFromFormat('H:i', $data['startTime']);
        $gameLength = $gameSettings[$data['sport']][$data['group']]['length'];
        $pause = $gameSettings[$data['sport']][$data['group']]['pause'];

        $slotLength = $gameLength + $pause;
        $busyTeams = [];

        // Plan wedstrijden in tijdsloten zonder teamconflicten
        while (count($fixturesToCreate) > 0) {
            $scheduledThisSlot = 0;
            $fieldNumber = 1;

            // Probeer maximaal het aantal beschikbare velden te vullen
            for ($i = 0; $i < count($fixturesToCreate) && $fieldNumber <= $fields; ) {
                $fixture = $fixturesToCreate[$i];
                $team1 = $fixture['team1'];
                $team2 = $fixture['team2'];

                // Controleer of teams nog bezig zijn met een andere wedstrijd
                $team1Busy = isset($busyTeams[$team1->id]) && $busyTeams[$team1->id]->gt($currentTime);
                $team2Busy = isset($busyTeams[$team2->id]) && $busyTeams[$team2->id]->gt($currentTime);

                if ($team1Busy || $team2Busy) {
                    // Kan deze wedstrijd nu niet plannen, probeer de volgende
                    $i++;
                    continue;
                }

                // Kies een scheidsrechter van een andere school
                $ref = Scheidsrechter::where('school_id', '!=', $team1->school_id)
                    ->where('school_id', '!=', $team2->school_id)
                    ->inRandomOrder()
                    ->first();

                $endTime = (clone $currentTime)->addMinutes($gameLength);

                Fixture::create([
                    'team_1_id' => $team1->id,
                    'team_2_id' => $team2->id,
                    'team_1_score' => 0,
                    'team_2_score' => 0,
                    'field' => $fieldNumber,
                    'start_time' => $currentTime->format('H:i'),
                    'end_time' => $endTime->format('H:i'),
                    'type' => 'pool',
                    'tournament_id' => $tournament->id,
                    'scheidsrechter_id' => $ref?->id,
                ]);

                // Markeer teams als bezet tot na pauze
                $busyUntil = (clone $endTime)->addMinutes($pause);
                $busyTeams[$team1->id] = $busyUntil;
                $busyTeams[$team2->id] = $busyUntil;

                // Verwijder geplande wedstrijd uit de lijst
                array_splice($fixturesToCreate, $i, 1);

                $scheduledThisSlot++;
                $fieldNumber++;
            }

            if ($scheduledThisSlot === 0) {
                // Geen wedstrijd mogelijk: ga naar eerstvolgende moment dat een team vrij is
                $earliest = null;
                foreach ($fixturesToCreate as $fixture) {
                    foreach ([$fixture['team1']->id, $fixture['team2']->id] as $tid) {
                        if (isset($busyTeams[$tid]) && $busyTeams[$tid]->gt($currentTime)) {
                            if ($earliest === null || $busyTeams[$tid]->lt($earliest)) {
                                $earliest = $busyTeams[$tid];
                            }
                        }
                    }
                }

                if ($earliest !== null) {
                    $currentTime = $earliest->copy();
                } else {
                    // Fallback: ga naar het volgende volledige tijdslot

                    $currentTime->addMinutes($slotLength);
                }
            } else {
                // Ga door naar het volgende tijdslot
                $currentTime->addMinutes($slotLength);
            }

        }

        return redirect()->route('admin.index')
            ->with('success', 'Toernooi succesvol aangemaakt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        $tournament = Tournament::with(['fixtures.team1', 'fixtures.team2'])
            ->findOrFail($tournament->id);


        $fixtures = $tournament->fixtures;


        return view('tournaments.show', compact('tournament', 'fixtures'));
        ;


    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {


        Team::where('tournament_id', $id)->update([
            'tournament_id' => null
        ]);


        $tournament = Tournament::findOrFail($id);
        $tournament->delete();

        return redirect()->route('tournaments.index')->with('success', 'Toernooi succesvol verwijderd.');
    }


public function showKnockouts(Tournament $tournament)
{
    // Laad alle knockout-wedstrijden van dit toernooi
    $knockouts = Fixture::where('tournament_id', $tournament->id)
        ->where('type', 'knockout') // Als je dit veld gebruikt om knockouts te onderscheiden
        ->with(['team1', 'team2'])
        ->get();

    return view('tournaments.knockouts', compact('tournament', 'knockouts'));
}


public function generateKnockouts(Tournament $tournament)
{
    // Check of knockouts al bestaan
    if(Fixture::where('tournament_id', $tournament->id)->where('type', 'knockout')->exists()){
        return redirect()->route('tournaments.knockouts', $tournament->id)
                         ->with('info', 'Knockouts zijn al gegenereerd.');
    }

    // Voorbeeld: de eerste 4 teams per poule naar knockout ronde
    $teams = Team::where('tournament_id', $tournament->id)
                 ->orderBy('pool')
                 ->orderByDesc('poulePoints') // hoogste punten eerst
                 ->get();

    $knockoutFixtures = [];

    // Simpel: per 2 teams 1 wedstrijd
    for ($i=0; $i < $teams->count(); $i+=2) {
        if(isset($teams[$i+1])) {
            $knockoutFixtures[] = [
                'team_1_id' => $teams[$i]->id,
                'team_2_id' => $teams[$i+1]->id,
                'team_1_score' => 0,
                'team_2_score' => 0,
                'field' => 1, // kan je dynamisch maken
                'start_time' => now()->format('H:i'),
                'end_time' => now()->addMinutes($tournament->game_length_minutes)->format('H:i'),
                'type' => 'knockout',
                'tournament_id' => $tournament->id,
                'scheidsrechter_id' => null,
            ];
        }
    }

    // Opslaan in DB
    foreach ($knockoutFixtures as $kf) {
        Fixture::create($kf);
    }

    return redirect()->route('tournaments.knockouts', $tournament->id)
                     ->with('success', 'Knockouts succesvol gestart!');
}





    public function getAllData()
    {
        $schools = School::all();
        $teams = Team::all();
        $users = User::all();
        $scheidsrechters = Scheidsrechter::all();

        return [
            'schools' => $schools,
            'teams' => $teams,
            'users' => $users,
            'scheidsrechters' => $scheidsrechters,
        ];
    }

    public function standings(Tournament $tournament)
    {
        $teams = Team::where('tournament_id', $tournament->id)
            ->orderByDesc('poulePoints')
            ->get();

        $stand = $teams->groupBy('pool')->sortkeys();

        return view('tournaments.standings', compact('tournament', 'teams', 'stand'));
    }
}

