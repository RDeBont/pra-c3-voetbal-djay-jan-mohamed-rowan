<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class FixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fixture $fixture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fixture $fixture)
    {
        return view('tournaments.fixturesedit', compact('fixture'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fixture $fixture)
    {
        $validatedData = $request->validate([
            'team_1_score' => 'required|integer|min:0|max:100',
            'team_2_score' => 'required|integer|min:0|max:100',
            'start_time' => 'required|date_format:H:i',
            'team_1_points' => 'nullable|integer|min:0|max:3',
            'team_2_points' => 'nullable|integer|min:0|max:3',
        ], [
            'team_1_score.required' => 'De score voor Team 1 is verplicht.',
            'team_1_score.integer' => 'De score voor Team 1 moet een geheel getal zijn.',
            'team_1_score.min' => 'De score voor Team 1 mag niet negatief zijn.',
            'team_1_score.max' => 'De score voor Team 1 mag niet hoger zijn dan 100.',
            'team_2_score.required' => 'De score voor Team 2 is verplicht.',
            'team_2_score.integer' => 'De score voor Team 2 moet een geheel getal zijn.',
            'team_2_score.min' => 'De score voor Team 2 mag niet negatief zijn.',
            'team_2_score.max' => 'De score voor Team 2 mag niet hoger zijn dan 100.',
            'start_time.required' => 'De starttijd is verplicht.',
            'start_time.date' => 'De starttijd moet een geldige tijd zijn.',
            'start_time.date_format' => 'De starttijd moet het formaat HH:MM hebben.',
            'team_1_points.integer' => 'De punten voor Team 1 moeten een geheel getal zijn.',
            'team_1_points.min' => 'De punten voor Team 1 mogen niet negatief zijn.',
            'team_1_points.max' => 'De punten voor Team 1 mogen niet hoger zijn dan 3.',
            'team_2_points.integer' => 'De punten voor Team 2 moeten een geheel getal zijn.',
            'team_2_points.min' => 'De punten voor Team 2 mogen niet negatief zijn.',
            'team_2_points.max' => 'De punten voor Team 2 mogen niet hoger zijn dan 3.',
        ]);


        $fixture->update($validatedData);
        $team1 = Team::find($fixture->team_1_id);
        $team2 = Team::find($fixture->team_2_id);

        if (isset($validatedData['team_1_points'])) {
            $team1->poulePoints = $validatedData['team_1_points'];
            $team1->save();
        }
        if (isset($validatedData['team_2_points'])) {
            $team2->poulePoints = $validatedData['team_2_points'];
            $team2->save();
        }

      
        return redirect()->route('tournaments.show', $fixture->tournament_id)
            ->with('success', 'Wedstrijd succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fixture $fixture)
    {
        //
    }
}

