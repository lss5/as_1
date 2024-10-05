<?php

namespace App\Providers;

use App\Company;
use App\Contact;
use App\Listing;
use App\Policies\CompanyPolice;
use App\Policies\ContactPolicy;
use App\Policies\ListingPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Company::class => CompanyPolice::class,
        Contact::class => ContactPolicy::class,
        Listing::class => ListingPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function($user){
            return $user->isAdmin();
        });

        Gate::define('moder', function($user){
            return $user->isAdmin() || $user->isModerator();
        });
    }
}
