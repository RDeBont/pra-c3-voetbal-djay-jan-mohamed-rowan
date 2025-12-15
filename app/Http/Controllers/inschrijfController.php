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
        return view('inschrijven');

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
            'email' => 'required|email|max:255|unique:schools,email',
            'address' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:20',
            'typeSchool' => 'required|string|in:basisschool,middelbare school',
            
        ],[
            'name.required' => 'De naam van de school is verplicht.',
            'email.required' => 'Het e-mailadres is verplicht.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'telefoonnummer.required' => 'Het telefoonnummer is verplicht.',
            'telefoonnummer.string' => 'Vul een geldig telefoonnummer in.',
            'telefoonnummer.max' => 'Het telefoonnummer mag niet langer zijn dan 20 tekens.',
            'telefoonnummer.unique' => 'Dit telefoonnummer is al in gebruik.',
            'address.required' => 'Het adres is verplicht.',
            'typeSchool.required' => 'Het type school is verplicht.',
            'typeSchool.in' => 'Ongeldig type school geselecteerd.',
        ]);





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
