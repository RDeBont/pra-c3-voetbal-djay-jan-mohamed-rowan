<?php

namespace App\Http\Controllers;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SchoolAccepted;
use Illuminate\Support\Facades\Mail;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::all();
        $schoolsAccepted = School::all()->where('accepted', 1);
        $schools = School::all()->where('accepted', 0);
        return view('admin.index', compact('schools', "schoolsAccepted", 'users'));
    }

    /**
     * Accept a school registration.
     */
    public function accept(string $id)
    {
        $school = School::findOrFail($id);
        $school->accepted = 1;
        $school->save();

        // Create 3 user accounts for this school and send credentials to the school's contact email
        $accounts = [];
        for ($i = 1; $i <= 3; $i++) {

            $password_plain = bin2hex(random_bytes(4)); // 8 hex chars

            $user = user::create([
                'name' => $school->name . ' - Account ' . $i,
                'email' => $school->email,
                'password' => bcrypt($password_plain),
                'school_id' => $school->id,
            ]);

            $accounts[] = [
                'email' => $school->email, 
                'password_plain' => $password_plain,
            ];
        }

        try {
            Mail::to($school->email)->send(new SchoolAccepted($school, $accounts));
        } catch (\Exception $e) {
            // Log mail failure but continue
            \Log::error('Failed to send acceptance email: ' . $e->getMessage());
        }

        return redirect()->route('admin.index')->with('success', 'School is geaccepteerd en accounts zijn aangemaakt.');
    }

    /**
     * Reject a school registration.
     */
    public function reject(string $id)
    {
        $school = School::findOrFail($id);

        User::where('school_id', $school->id)->delete();

        $school->delete();

        return redirect()->route('admin.index')->with('success', 'School en gekoppelde gebruikers zijn verwijderd.');
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
