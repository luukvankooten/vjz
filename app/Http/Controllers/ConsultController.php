<?php

namespace App\Http\Controllers;

use App\{
    Disease, Group, Medicine, Role, Room, User, Consult
};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ConsultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:consult');
    }

    public function index()
    {
        $medicines = Medicine::select('medicine', 'factory', 'id')->get();

        $diseases = Disease::select('disease', 'body_part', 'id')->get();

        $users = \Auth::user()->hasRole('Huisarts') ? \Auth::user()->user()->get() :
            Role::whereName('Gebruiker')->first()->users;

        $hospitals = Group::whereHas('role', function ($query) {
            $query->where('name', 'Ziekenhuis');
        })->pluck('name', 'id');

        return view('main.consult.register', compact('users', 'medicines', 'diseases', 'hospitals'));
    }

    /**
     * Its the hard part... learning
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->create($request->all());

        return redirect('consult')->with('status', 'Behandeling aangemaakt.');
    }

    /**
     * validate the incoming request
     *
     * @param array $data
     * @return mixed
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'names' => 'exists:users,name|required|string',
            'disease' => 'exists:diseases,id|required|numeric',
            'details' => 'required|string',
            'medicine' => 'exists:medicines,id|required|numeric',
            'files' => 'max:10',
            'files.*' => 'file|mimes:jpg,jpeg,png,doc,docx,docb,pdf|max:2048',
            'info.*' => 'sometimes',
            'info.hospital' => 'sometimes|required|exists:groups,id|string',
            'info.bed' => 'sometimes|required|string',
            'info.room' => 'sometimes|required|string',
        ]);
    }

    /**
     * Write the request to the database
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $consult = Consult::create([
            'details' => $data['details'],
        ]);

        if (!auth()->user()->hasRole('Huisarts') && isset($data['info'])) {
            $consult->room()->save(
                new Room([
                    'hospital_id' =>  $data['info']['hospital'],
                    'bed' => $data['info']['bed'],
                    'room' => $data['info']['room'],
                ])
            );
        }

        $user = User::whereName($data['names'])->first();

        $user->consult()->attach([
            [
                'user_id' => $user->id,
                'disease_id' => $data['disease'],
                'consult_id' => $consult->id,
                'medicine_id' => $data['medicine'],
                'practitioner_id' => auth()->user()->id,
            ]
        ]);

        $dir = $user->id.'/consult/'.$consult->id;
        foreach ($data['files'] as $image) {
            Storage::putFileAs($dir, $image, $image->getClientOriginalName());
        }

        return $consult;
    }
}
