<?php

namespace App\Providers;

use App\Contracts\ImportData\NetworkPrice;
use App\Services\ImportData\Binance;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(NetworkPrice::class, function ($app) {
            return new Binance();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
