<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
            'school_id' => 'nullable|integer|exists:schools,id',
        ], [
            'name.required' => 'De naam is verplicht.',
            'email.required' => 'Het e-mailadres is verplicht.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'password.required' => 'Het wachtwoord is verplicht.',
            'password.min' => 'Het wachtwoord moet minimaal 8 tekens bevatten.',
            'password.confirmed' => 'De wachtwoorden komen niet overeen.',
            'is_admin.required' => 'Geef aan of de gebruiker admin-rechten heeft.',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'is_admin' => $validatedData['is_admin'],
            'school_id' => $validatedData['school_id'] ?? null, 
        ]);
        return redirect()->route('admin.index')->with('success', 'Gebruiker succesvol aangemaakt!');

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
        $user = User::findOrFail($id);
        return view('admin.usersEdit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validatie
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ], [
            'name.required' => 'De naam is verplicht.',
            'email.required' => 'Het e-mailadres is verplicht.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'password.min' => 'Het wachtwoord moet minimaal 8 tekens bevatten.',
            'password.confirmed' => 'De wachtwoorden komen niet overeen.',
            'is_admin.required' => 'Geef aan of de gebruiker admin-rechten heeft.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;


        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.index')->with('success', 'Gebruiker succesvol bijgewerkt!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User Successvol verwijderd.');

    }
}
