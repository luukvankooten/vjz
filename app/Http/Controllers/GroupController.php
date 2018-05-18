<?php

namespace App\Http\Controllers;

use App\{
    Address, Role, User, Group
};
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:groepen');
    }

    public function index()
    {
        $roles = Role::whereIn('name', ['Verzekering', 'Ziekenhuis'])->pluck('name', 'id');
        return view('main.group.register', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|exists:roles,id',
            'name' => 'required|string|max:255|unique:groups,name',
            'description' => 'required|string',
            'address.establishment' => 'required|string|max:255',
            'address.street' => 'required|string|max:255',
            'address.number' => 'required|integer|digits_between:1,6',
            'address.affix' => 'nullable',
            'address.zip' => 'required|regex:/[0-9]{4}[A-Z]{2}/',
        ]);

        $adrress = Address::create([
            'establishment' => $request->input('address.establishment'),
            'street' => $request->input('address.street'),
            'number' => $request->input('address.number'),
            'addition' => $request->input('address.affix'),
            'zip' => $request->input('address.zip'),
        ]);

        Group::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type_id' => $request->input('type'),
            'address_id' => $adrress->id,
        ]);

        return redirect('groepen')->with('status', 'Groep succesvol aangemaakt.');
    }

    public function show()
    {
        $users = User::all()->pluck('name', 'id');
        $insurances = Group::all()->pluck('name', 'id');
        return view('main.group.assign',  compact('users', 'insurances'));
    }

    public function assign(Request $request)
    {
//        $request->validate([
//            'na'
//        ]);
    }
}
