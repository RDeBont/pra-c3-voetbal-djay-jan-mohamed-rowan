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
class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = Tournament::all();

        return view('tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all = $this->getAllData();
        return view('tournaments.createTournament', compact('all'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
    // Validatie
    $data = $request->validate([
        'name' => 'required|string',
        'sport' => 'required|in:voetbal,lijnbal',
        'group' => 'required|in:groep3/4,groep5/6,groep7/8,klas1_jongens,klas1_meiden',
        [
            'name.required' => 'De naam van het toernooi is verplicht.',
            'sport.required' => 'De sport is verplicht.',
            'group.required' => 'De groep is verplicht.',
            'name.string' => 'De naam van het toernooi moet een geldige tekst zijn.',
            'sport.in' => 'De geselecteerde sport is ongeldig.',
            'group.in' => 'De geselecteerde groep is ongeldig.',
        ]
    ]);

    // Check of toernooi al bestaat
    if (Tournament::where('name', $data['name'])->exists()) {
        return redirect()->back()->withErrors(['name' => 'Er bestaat al een toernooi met deze naam.'])->withInput();
    }

    // Ophalen van teams (alleen teams die nog niet aan een toernooi gekoppeld zijn)
    $teams = Team::where('sport', $data['sport'])
        ->where('group', $data['group'])
        ->whereNull('tournament_id')
        ->get()
        ->shuffle();




    // Bepaal aantal velden op basis van sport en groep
    if ($data['sport'] === 'lijnbal') {
    $fields = 4;
    } else {
    switch ($data['group']) {
        case 'groep3/4':
            $fields = 4;
            break;

        case 'groep5/6':
        case 'groep7/8':
            $fields = 8;
            break;

        case 'klas1_jongens':
            $fields = 3;
            break;

        case 'klas1_meiden':
            $fields = 4;
            break;
        }
    }

    // Aantal teams per poule
    $teamsPerPool = 4;
    $teamCount = $teams->count();

    // Controleer of er genoeg teams zijn
    if ($teamCount < $teamsPerPool) {
        return redirect()->back()->withErrors(['team' => 'Er zijn niet genoeg teams beschikbaar voor dit toernooi.'])->withInput();
    }



    // Teams groeperen per school
    $teamsBySchool = $teams->groupBy('school_id');

    // Aantal poules bepalen
    $pouleCount = (int) ceil($teamCount / $teamsPerPool);

    // Lege poules aanmaken
    $poules = array_fill(0, $pouleCount, []);

    // Round-Robin verdeling om conflicts te voorkomen
    $index = 0;
    foreach ($teamsBySchool as $schoolTeams) {
        if (count($schoolTeams) > $pouleCount) {
            return redirect()->back()->withErrors(['team' => 'Te veel teams van dezelfde school om een eerlijk toernooi te maken.'])->withInput();
        }
        else{
             foreach ($schoolTeams as $team) {
            $pouleIndex = $index % $pouleCount;
            $poules[$pouleIndex][] = $team;
            $index++;
        }

        }
       
    }

    

    // Maak toernooi
    $tournament = Tournament::create([
        'name' => $data['name'],
        'date' => now()->toDateString(),
        'fields_amount' =>  $fields,
        'game_length_minutes' => 10,
        'amount_teams_pool' => $teamsPerPool,
        'archived' => false,
    ]);


    
    // Alle teams in een enkele collectie
    $teams = collect($poules)->flatten();


    // Teams toewijzen aan poules
    foreach ($teams->values() as $index => $team) {
        $poolNumber = (int) floor($index / $teamsPerPool) + 1;
        $team->update([
            'pool' => $poolNumber,
            'tournament_id' => $tournament->id,
        ]);
    }

   

    // Wedstrijden aanmaken
    $startTime = '08:00';
    $gameLength = $tournament->game_length_minutes;

    $teamsByPool = $teams->groupBy('pool');

    foreach ($teamsByPool as $poolTeams) {
        $poolTeamsList = $poolTeams->values()->all();

        // Iedereen speelt tegen elkaar in de poule
        for ($i = 0; $i < count($poolTeamsList); $i++) {
            for ($j = $i + 1; $j < count($poolTeamsList); $j++) {

                // Bepaal scheidsrechter die niet van een van de teams is
                $team1School = $poolTeamsList[$i]->school_id;
                $team2School = $poolTeamsList[$j]->school_id;

                $eligibleReferees = Scheidsrechter::where('school_id', '!=', $team1School)
                    ->where('school_id', '!=', $team2School)
                    ->inRandomOrder()
                    ->first();

                Fixture::create([
                    'team_1_id' => $poolTeamsList[$i]->id,
                    'team_2_id' => $poolTeamsList[$j]->id,
                    'team_1_score' => 0,
                    'team_2_score' => 0,
                    'field' => rand(1, $fields),
                    'start_time' => $startTime,
                    'type' => 'pool',
                    'tournament_id' => $tournament->id,
                    'scheidsrechter_id' => $eligibleReferees ? $eligibleReferees->id : null,
                ]);
            }
        }
    }

    return redirect()->route('admin.index')->with('success', 'Toernooi succesvol aangemaakt!');
}

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        $tournament = Tournament::with(['fixtures.team1', 'fixtures.team2'])
            ->findOrFail($tournament->id);

        $fixtures = $tournament->fixtures;
        

        return view('tournaments.show', compact('tournament', 'fixtures'));;


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
