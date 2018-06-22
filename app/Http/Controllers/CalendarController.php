<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Role};

class CalendarController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth', 'can:calender']);
        $this->middleware('can:create-appointments')->only('create');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('main.calender.index');
    }

    public function create()
    {
        $users = \Auth::user()->hasRole('Huisarts') ? \Auth::user()->user()->get() :
            Role::whereName('Gebruiker')->first()->users;
        return view('main.calender.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'users' => 'required|string|exists:users,name',
            'date' => 'required|date',
            'time' => 'required|date',
            'description' => 'required|string',
        ]);
    }
}
