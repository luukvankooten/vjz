<?php

namespace App\Http\Controllers\Auth;

use App\{Role, User, Group, Address};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterUserController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/registreer';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:registreer');
    }


    /**
     * Register an user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = User::isAdmin()? Role::all()->pluck('name', 'id') :
                Role::whereNotIn('name', ['Admin', 'Webmaster'])->pluck('name', 'id');

        $practitioners = Role::whereName('Huisarts')->first()->users->pluck('name', 'id');

        $groups = User::isAdmin() ? Group::all()->pluck('name', 'id') : null;
        return view('main.user.register', compact('roles', 'practitioners', 'groups'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($this->create($request->all())));

        return redirect('registreer')->with('status', 'Gebruiker met succes aangemaakt.');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'role' => 'required|exists:roles,name|string',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'group' => 'nullable|required_if:role,Gebruiker,Ziekenhuis,Verzekering|string|exists:groups,name',
            'practitioner' => 'sometimes|required_if:role,Gebruiker|required|string|exists:users,name',
            'address.establishment' => 'sometimes|required|string|max:255',
            'address.street' => 'sometimes|required|string|max:255',
            'address.number' => 'sometimes|required|integer|digits_between:1,6',
            'address.addition' => 'attach|nullable|string',
            'address.zip' => 'sometimes|required|regex:/[0-9]{4}[A-Z]{2}/'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * Assign a Practitioner to user.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($data['role']);
        $this->createAddress($user, $data['address']);
        $this->attach($user, $data);

        if (!empty($data['group']) &&
            !isset($data['address'])) {
            $group = Group::whereName($data['group'])->first();
            $user->address()->attach($group->address->first()->id);
            $user->groups()->attach($group->id);
        }

        return $user;
    }

    /**
     * Create address if isset.
     *
     * @param User $user
     * @param array $data
     * @return mixed
     */
    protected function createAddress(User $user, array $data)
    {
        return isset($data) ? $user->address()->save(new Address($data)) : null;
    }

    /**
     * attach if user contain certain role.
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    protected function attach(User $user, array $data)
    {
        switch ($data['role']) {
            case 'Gebruiker':
                $name = User::whereName($data['practitioner'])->first()->id;
                $user->practitioner()->attach($name);
                break;
            case 'Verpleegkundige':
                $user->createToken('App')->accessToken;
                break;
        }
    }
}
