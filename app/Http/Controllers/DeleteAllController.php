<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scheidsrechter;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\School;
use App\Models\User;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;

class deleteAllController extends Controller
{
    /**Display a listing of the resource.*/
    public function destroy()
    {
        DB::transaction(function () {
            Fixture::query()->delete();
            Team::query()->delete();
            Scheidsrechter::query()->delete();
            School::query()->delete();
            Tournament::query()->delete();
            User::where('is_admin', '!=', 1)->delete();
        });
        return redirect()->route('admin.index')->with('success', 'Alle gegevens zijn succesvol verwijderd.');
    }
}