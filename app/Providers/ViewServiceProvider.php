<?php

namespace App\Providers;

use App\View\Composers\FooterComposer;
use App\View\Composers\ListingComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('partials.footer', FooterComposer::class);

        View::composer('listings.*', ListingComposer::class);
    }
}
