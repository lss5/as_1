<?php

namespace App\View\Composers;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ProfileComposer
{
    public function __construct(
        private Country $country,
    ) {}


    public function compose(View $view): void
    {
        $countries = Cache::rememberForever(Country::CACHE_KEY_ALL, function () {
            return $this->country->orderBy('name', 'asc')->get();
        });

        $view->with('countries', $countries);
    }
}
