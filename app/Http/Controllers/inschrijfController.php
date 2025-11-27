<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class inschrijfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inschrijven', ) ;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'typeSchool' => 'required|string|in:basisschool,middelbare school',
        ]);
        
        // Map schoolNaam to name for database

        
        School::create($validatedData);
        return redirect('/')->with('success', 'School succesvol ingeschreven! het kan even duren voordat uw school is goedgekeurd.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
