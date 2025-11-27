<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Scheidsrechter;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;


class teamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $school = School::where('id', $user->school_id)->first(); // 1 record
        return view('team', compact('school'));
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
        $school = Auth::user()->school;

        // Validatie scheidsrechters
        $request->validate([
            'hoeveel_scheid' => 'required|integer|min:0|max:5',
        ]);

        // Opslaan scheidsrechters
        $aantalScheids = $request->input('hoeveel_scheid');
        for ($i = 1; $i <= $aantalScheids; $i++) {
            $email = $request->input('scheidsrechter_email_' . $i);
            if ($email) {
                Scheidsrechter::create([
                    'school_id' => $school->id,
                    'name' => $email,
                ]);
            }
        }

        // Teams opslaan
        $teams = $request->input('teams', []);
        foreach ($teams as $sport => $groups) {
            foreach ($groups as $groupName => $teamList) {
                foreach ($teamList as $teamData) {
                    // dd($teamData); 
                    Team::create([
                        'school_id' => $school->id,
                        'name' => $teamData['name'],
                        'sport' => $teamData['sport'],
                        'group' => $teamData['group'],
                        'referee' => null,
                        'pool_id' => null,
                    ]);
                }
            }
        }
        return redirect('/')->with('success', 'School succesvol ingeschreven! ze zullen nu toegevoegd worden aan de competitie.');
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
