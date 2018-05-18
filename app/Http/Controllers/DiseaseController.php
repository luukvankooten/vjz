<?php

namespace App\Http\Controllers;

use App\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:aandoeningen');
    }

    public function index()
    {
        return view('main.consult.disease');
    }

    public function store(Request $request)
    {
        $request->validate([
            'body_part' => 'required|string',
            'disease' => 'required|string',
        ]);

        Disease::create($request->all());

        return redirect('aandoeningen')->with('status', 'Aandoening aangemaakt.');
    }
}
