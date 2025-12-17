<?php

namespace App\Http\Controllers;

use App\Models\Scheidsrechter;
use App\Http\Requests\StoreScheidsrechterRequest;
use App\Http\Requests\UpdateScheidsrechterRequest;
use Illuminate\Http\Request;

class ScheidsrechterController extends Controller
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:scheidsrechters,email',
            'school_id' => 'required|exists:schools,id',
            [
                'name.required' => 'De naam van de scheidsrechter is verplicht.',
                'email.required' => 'Het e-mailadres is verplicht.',
                'email.email' => 'Vul een geldig e-mailadres in.',
                'email.unique' => 'Dit e-mailadres is al in gebruik.',
                'school_id.required' => 'De school is verplicht.',
                'school_id.exists' => 'Geselecteerde school bestaat niet.',
            ]
        ]);

        Scheidsrechter::create($validated);

        return redirect()->route('admin.index')->with('success', 'Scheidsrechter succesvol aangemaakt!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Scheidsrechter $scheidsrechter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scheidsrechter $scheidsrechter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheidsrechterRequest $request, Scheidsrechter $scheidsrechter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $scheidsrechter = Scheidsrechter::findOrFail($id);
        $scheidsrechter->delete();

        return redirect()->back()->with('success', 'Scheidsrechter succesvol verwijderd!');

    }
}
