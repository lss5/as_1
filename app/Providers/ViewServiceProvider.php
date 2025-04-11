<?php

namespace App\Providers;

use App\View\Composers\FooterComposer;
use App\View\Composers\ListingComposer;
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('partials.footer', FooterComposer::class);

        View::composer('listings.*', ListingComposer::class);

        View::composer('profile.index', ProfileComposer::class);
    }
}
