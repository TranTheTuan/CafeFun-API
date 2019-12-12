<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
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
        
        Gate::define('manage', function($user, $restaurant) {
            $can_manage = false;
            $employee = $user->employee;
            if(!is_null($employee)) {
                if($restaurant->employees->contains($employee)) {
                    foreach($employee->roles as $role) {
                        if($role->pivot->role_id == 1) {
                            $can_manage = true;
                        }
                    }
                }
            }
            if($restaurant->user->is($user)) {
                $can_manage = true;
            }
            return $can_manage;
        });

        Gate::define('order', function($user, $restaurant) {
            $can_order = false;
            $employee = $user->employee;
            if(is_null($employee)) {
                $can_order = true;
            } else {
                if($restaurant->employees->contains($employee)) {
                    foreach($employee->roles as $role) {
                        if($role->pivot->role_id == 3) {
                            $can_order = true;
                        }
                    }
                }
            }
            return $can_order;
        });

        Gate::define('handle_order', function($user, $restaurant) {
            $can_handle_order = false;
            $employee = $user->employee;
            if(!is_null($employee)) {
                if($restaurant->employees->contains($employee)) {
                    foreach($employee->roles as $role) {
                        if($role->pivot->role_id == 2) {
                            $can_handle_order = true;
                        }
                    }
                }
            }
            if($restaurant->user->is($user)) {
                $can_handle_order = true;
            }
            return $can_handle_order;
        });
    }
}
