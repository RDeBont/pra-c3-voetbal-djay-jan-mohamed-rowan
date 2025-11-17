<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;

class TournamentCreateController extends Controller
{
	/**
	 * Show the form to create a tournament.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function create()
	{
		return view('admin.create');
	}

	public function store(Request $request)
	{


		$validate = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'date' => ['required', 'date'],
			'type' => ['nullable', 'string', 'max:100'],
			'fields_amount' => ['nullable', 'integer', 'min:1'],
			'game_length_minutes' => ['nullable', 'integer', 'min:1'],
			'amount_teams_pool' => ['nullable', 'integer', 'min:1'],
			'archived' => ['nullable', 'boolean'],
		]);


		Tournament::create($validate);


		return redirect('/admin');
	}
}
