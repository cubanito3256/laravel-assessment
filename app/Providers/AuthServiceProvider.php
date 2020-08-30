<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        // register passport routes
        Passport::routes();

        // sets id for passport token generation
        Passport::personalAccessClientId(
            config('passport.personal_access_client.id')
        );
    
        // sets secret for passport token generation
        Passport::personalAccessClientSecret(
            config('passport.personal_access_client.secret')
        );
    }
}
