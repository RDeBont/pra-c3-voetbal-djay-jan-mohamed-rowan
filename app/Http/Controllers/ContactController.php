<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactBericht;

class ContactController extends Controller
{
    public function verzenden(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email',
            'bericht' => 'required|string',
        ]);

        Mail::to('info@jouwsite.nl')->send(new ContactBericht($request->all()));

        return redirect()->route('contact')->with('success', 'Je bericht is verzonden!');
    }
}
