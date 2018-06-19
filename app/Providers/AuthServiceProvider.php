<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensCan([
            'app-login' => 'Use the app',
        ]);

        if (Schema::hasTable('permission_role')) {
            foreach (Permission::getPermissions() as $permission) {
                Gate::define(strtolower($permission->name), function ($user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }
        }

        Gate::before(function ($user) {
            if ($user->hasRole('Admin')) {
                return true;
            }
        });

        Gate::define('view-treatment', function ($user, $consult) {
            return $user->owns($consult);
        });
    }
}
