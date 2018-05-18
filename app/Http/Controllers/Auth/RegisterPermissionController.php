<?php

namespace App\Http\Controllers\Auth;

use App\Permission;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterPermissionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:permissies');
    }

    /**
     * Show register from
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Permission $permission, Role $role)
    {
        $permissions = $permission->pluck('name', 'id')->toArray();
        $roles = $role->where('name', '!=', 'Admin')->get();
        return view('main.permission.register', compact('permissions', 'roles'));
    }

    /**
     * Add/Update role permission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'permissions.*' => 'required_without_all',
            'permissions.*.*' => 'boolean',
        ]);

        foreach ($request->input('permissions') as $role => $value) {
            $role = Role::whereName(ucfirst($role))->firstOrFail();
            foreach ($value as $permission => $boolean) {
                $boolean = filter_var($boolean, FILTER_VALIDATE_BOOLEAN);
                $permission = Permission::whereName(ucfirst($permission))->firstOrFail();
                if ($boolean && !$role->hasPermission($permission->name)) {
                    $role->permissions()->attach($permission->id);
                } elseif (!$boolean && $role->hasPermission($permission->name)) {
                    $role->permissions()->detach($permission->id);
                }
            }
        }

        return redirect('permissies')->with('status', 'Permissie met succes gewijzigd.');
    }


}
