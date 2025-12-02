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
        return view('tournaments..createTournament', compact('all'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        //
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
    public function destroy(Tournament $tournament)
    {
        //
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
