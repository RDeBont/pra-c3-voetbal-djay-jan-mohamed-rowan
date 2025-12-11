<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Tournament;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\School;
use App\Models\Team;
use App\Models\User;
use App\Models\Scheidsrechter;
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
        $data = $request->validate([
            'name' => 'required|string',
            'sport' => 'required|in:voetbal,lijnbal',
            'group' => 'required|in:groep3/4,groep5/6,groep7/8,klas1_jongens,klas1_meiden',
            'date' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'teamsPerPool' => 'required|integer|min:2',
        ], [
            'name.required' => 'De naam van het toernooi is verplicht.',
            'name.string' => 'De naam van het toernooi moet een geldige tekst zijn.',
            'sport.required' => 'De sport is verplicht.',
            'sport.in' => 'De geselecteerde sport is ongeldig.',
            'group.required' => 'De groep is verplicht.',
            'group.in' => 'De geselecteerde groep is ongeldig.',
            'date.required' => 'Datum van het toernooi is verplicht.',
            'startTime.required' => 'Starttijd van het toernooi is verplicht.',
            'startTime.date_format' => 'Starttijd moet het formaat HH:MM hebben.',
            'teamsPerPool.required' => 'Aantal teams per poule is verplicht.',
        ]);

        if (Tournament::where('name', $data['name'])->exists()) {
            return redirect()->back()->withErrors(['name' => 'Er bestaat al een toernooi met deze naam.'])->withInput();
        }

        $teams = Team::where('sport', $data['sport'])
            ->where('group', $data['group'])
            ->whereNull('tournament_id')
            ->get()
            ->shuffle();

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
            ],
        ];

        $settings = $gameSettings[$data['sport']][$data['group']];
        $fields = $settings['fields'];
        $playTime = $settings['length'];
        $pause = $settings['pause'];
        $teamsPerPool = $data['teamsPerPool'];
        $teamCount = $teams->count();

        if ($teamCount < $teamsPerPool) {
            return redirect()->back()->withErrors(['team' => 'Niet genoeg teams beschikbaar.'])->withInput();
        }

        if ($teamCount % $teamsPerPool === 1) {
            return redirect()->back()->withErrors(['team' => 'Er blijft 1 team over. Pas het aantal teams per poule aan of voeg teams toe.'])->withInput();
        }

        $teamsBySchool = $teams->groupBy('school_id');
        $pouleCount = (int) ceil($teamCount / $teamsPerPool);
        $poules = array_fill(0, $pouleCount, []);

        $index = 0;
        foreach ($teamsBySchool as $schoolTeams) {
            if (count($schoolTeams) > $pouleCount) {
                return redirect()->back()->withErrors(['team' => 'Te veel teams van dezelfde school.'])->withInput();
            }
            foreach ($schoolTeams as $team) {
                $pouleIndex = $index % $pouleCount;
                $poules[$pouleIndex][] = $team;
                $index++;
            }
        }

        $tournament = Tournament::create([
            'name' => $data['name'],
            'date' => $data['date'],
            'fields_amount' => $fields,
            'game_length_minutes' => $playTime,
            'amount_teams_pool' => $teamsPerPool,
            'archived' => false,
        ]);

        $teams = collect($poules)->flatten();

        foreach ($teams->values() as $index => $team) {
            $poolNumber = (int) floor($index / $teamsPerPool) + 1;
            $team->update([
                'pool' => $poolNumber,
                'tournament_id' => $tournament->id,
            ]);
        }

        // Starttijd en veldtijden
        $startTime = Carbon::createFromFormat('H:i', $data['startTime']);
        $fieldTimes = [];
        for ($f = 1; $f <= $fields; $f++) {
            $fieldTimes[$f] = $startTime->copy();
        }

        $teamsByPool = $teams->groupBy('pool');
        foreach ($teamsByPool as $poolTeams) {
            $poolTeamsList = $poolTeams->values()->all();
            for ($i = 0; $i < count($poolTeamsList); $i++) {
                for ($j = $i + 1; $j < count($poolTeamsList); $j++) {
                    // Veld met vroegste tijd kiezen
                    $earliestField = null;
                    $earliestTime = null;
                    foreach ($fieldTimes as $f => $time) {
                        if (is_null($earliestTime) || $time->lt($earliestTime)) {
                            $earliestTime = $time;
                            $earliestField = $f;
                        }
                    }
                    $field = $earliestField;
                    $start = $earliestTime->copy();

                    // Scheidsrechter
                    $team1School = $poolTeamsList[$i]->school_id;
                    $team2School = $poolTeamsList[$j]->school_id;
                    $eligibleReferee = Scheidsrechter::where('school_id', '!=', $team1School)
                        ->where('school_id', '!=', $team2School)
                        ->inRandomOrder()
                        ->first();

                    Fixture::create([
                        'team_1_id' => $poolTeamsList[$i]->id,
                        'team_2_id' => $poolTeamsList[$j]->id,
                        'team_1_score' => 0,
                        'team_2_score' => 0,
                        'field' => $field,
                        'start_time' => $start->format('H:i'),
                        'end_time' => $start->copy()->addMinutes($playTime)->format('H:i'),
                        'type' => 'pool',
                        'tournament_id' => $tournament->id,
                        'scheidsrechter_id' => $eligibleReferee ? $eligibleReferee->id : null,
                    ]);

                    $fieldTimes[$field]->addMinutes($playTime + $pause);
                }
            }
        }

        return redirect()->route('admin.index')->with('success', 'Toernooi succesvol aangemaakt!');
    }

    public function show(Tournament $tournament)
    {
        $tournament = Tournament::with(['fixtures.team1', 'fixtures.team2'])
            ->findOrFail($tournament->id);
        $fixtures = $tournament->fixtures;
        return view('tournaments.show', compact('tournament', 'fixtures'));
    }

    public function edit(Tournament $tournament)
    {
        //
    }

    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        //
    }

    public function destroy($id)
    {
        Team::where('tournament_id', $id)->update(['tournament_id' => null]);
        $tournament = Tournament::findOrFail($id);
        $tournament->delete();
        return redirect()->route('tournaments.index')->with('success', 'Toernooi succesvol verwijderd.');
    }

    public function getAllData()
    {
        return [
            'schools' => School::all(),
            'teams' => Team::all(),
            'users' => User::all(),
            'scheidsrechters' => Scheidsrechter::all(),
        ];
    }

    public function standings(Tournament $tournament)
    {
        $teams = Team::where('tournament_id', $tournament->id)
            ->orderByDesc('poulePoints')
            ->get();
        $stand = $teams->groupBy('pool')->sortKeys();
        return view('tournaments.standings', compact('tournament', 'teams', 'stand'));
    }
}
