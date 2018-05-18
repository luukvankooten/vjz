<?php

namespace App\Http\Controllers\Auth;

use App\Permission;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterRoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:rollen');
    }

    /**
     * Register an role.
     *
     * @param Permission $permissions
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Permission $permissions)
    {
        return view('main.role.register')->with('permissions', $permissions->pluck('name', 'id'));
    }

    /**
     * Validate and write to database
     *
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'description' => 'required',
            'permissions' => 'required_without_all',
        ]);

        foreach ($request->input('permissions') as $per)
        {
            $permission[] = Permission::where('name', $per)->first();
        }

        $role->create($request->only(['name', 'description']))
             ->permissions()->saveMany($permission);

        return redirect('rollen')->with('status', 'Rol succes vol aangemaakt.');
    }
}
