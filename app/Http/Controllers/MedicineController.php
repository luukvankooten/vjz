<?php

namespace App\Http\Controllers;

use App\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:medicijnen');
    }

    public function index()
    {
        return view('main.consult.medicine');
    }

    public function store(Request $request)
    {
        $request->validate([
            'factory' => 'required',
            'medicine' => 'required',
        ]);

        Medicine::create($request->all());

        return redirect('medicijnen')->with('status', 'Medicijn aangemaakt.');
    }
}
