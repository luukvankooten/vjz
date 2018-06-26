<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Allergy, Role, User
};
class AllergyController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'can:allergieen']);
    }

    public function create()
    {
        $users = \Auth::user()->hasRole('Huisarts') ? \Auth::user()->user()->get() :
            Role::whereName('Gebruiker')->first()->users;

        $allergies = [];

        return view('main.allergy.create', compact('users', 'allergies'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user' => 'exists:users,name|required|string',
            'allergy' => 'string|required',
        ]);

        $user = User::whereName($request->user)->first()->id;

        $allergy = Allergy::create([
            'allergy' => $request->allergy,
        ]);


        $allergy->user()->attach($user);

        return redirect('allergieen')->with('status', 'Allergie ingevoerd.');

    }
}
