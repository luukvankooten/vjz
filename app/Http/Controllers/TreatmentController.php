<?php

namespace App\Http\Controllers;

use Gate;
use App\Consult;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    /**
     * TreatmentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:behandelingen');
    }

    /**
     * Show all treatments belongs to user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Consult $consult)
    {
        $treatments = \Auth::user()->hasRole('Gebruiker')? \Auth::user()->consult()->paginate(14) :
            $consult->paginate(14);
        return view('main.treatment.index', compact('treatments'));
    }

    /**
     * Show treatment of user
     *
     * @param Consult $consult
     * @return bool
     */
    public function show(Consult $consult)
    {
        $treatment = $consult->with(['user', 'medicine', 'disease'])->first();

        if (Gate::denies('view-treatment', $treatment->user[0])){
            abort(403, 'Toegang niet geaccepteerd');
        }

        return view('main.treatment.show', compact('treatment'));
    }
}
