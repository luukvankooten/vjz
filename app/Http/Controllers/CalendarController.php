<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\{
    Calendar, Role, User
};

class CalendarController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth', 'can:agenda']);
        $this->middleware('can:afspraken')->only(['create', 'store']);
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
            'date' => 'required|date_format:"Y-m-d"',
            'time' => 'required|date_format:"H:i"',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:16777215',
        ]);

        $user = User::whereName($request->users)->first()->id;
        $date = (new Carbon($request->date . $request->time))->toDateTimeString();

        Calendar::create([
            'user_id' => $user,
            'creator_id' => auth()->user()->id,
            'datetime' => $date,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect('afspraak')->with('status', 'Afspraak succesvol aangemaakt.');
    }
}
