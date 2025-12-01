<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        ]);

        $fixture->update($validatedData);

        return redirect()->route('tournaments.show', $fixture->tournament_id)
            ->with('success', 'Wedstrijdscore succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fixture $fixture)
    {
        //
    }
}
