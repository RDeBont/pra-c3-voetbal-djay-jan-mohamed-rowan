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

        $data = $request->validate([
            'name' => 'required|string',
            'sport' => 'required|in:voetbal,lijnbal',
            'group' => 'required|in:groep3/4,groep5/6,groep7/8,klas1_jongens,klas1_meiden',
        ]);

        if (Tournament::where('name', $data['name'])->exists()) {
            return redirect()->back()->withErrors(['name' => 'Er bestaat al een toernooi met deze naam.'])->withInput();
        } else {


            $teamsPerPool = $tournament->amount_teams_pool ?? 4;
            $teams = Team::where('sport', $data['sport'])
                ->where('group', $data['group'])
                ->get()
                ->shuffle();

            $teamCount = $teams->count();


            if ($teamCount < $teamsPerPool) {
                return redirect()->back()->withErrors(['team' => 'Er zijn niet genoeg teams beschikbaar voor dit toernooi.'])->withInput();
            }

            $tournament = Tournament::create([
                'name' => $data['name'],
                'date' => now()->toDateString(),
                'fields_amount' => 4,
                'game_length_minutes' => 10,
                'amount_teams_pool' => 4,
                'archived' => false,
            ]);

            // pools maken

            foreach ($teams->values() as $index => $team) {
                $poolNumber = (int) floor($index / $teamsPerPool) + 1;
                $team->update([
                    'pool' => $poolNumber,
                    'tournament_id' => $tournament->id,
                ]);
            }


            $field = 1;
            $startTime = '08:00';
            $gameLength = $tournament->game_length_minutes;

            $teamsByPool = $teams->groupBy('pool');

            foreach ($teamsByPool as $poolTeams) {
                $poolTeamsList = $poolTeams->values()->all();

                //Zorgt ervoor dat iedereen indezelfde pool tegen elkaar speelt
                for ($i = 0; $i < count($poolTeamsList); $i++) {
                    for ($j = $i + 1; $j < count($poolTeamsList); $j++) {
                        Fixture::create([
                            'team_1_id' => $poolTeamsList[$i]->id,
                            'team_2_id' => $poolTeamsList[$j]->id,
                            'team_1_score' => 0,
                            'team_2_score' => 0,
                            'field' => $field,
                            'start_time' => $startTime,
                            'type' => 'pool',
                            'tournament_id' => $tournament->id,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.index')->with('success', 'Toernooi succesvol aangemaakt!');

        }






    }




    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        $tournament = Tournament::with(['fixtures.team1', 'fixtures.team2'])
            ->find($tournament->id);

        $fixtures = $tournament->fixtures;

        return view('tournaments.show', compact('tournament', 'fixtures'));


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
}
