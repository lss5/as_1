<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Listing;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ListingComposer
{
    public function __construct(
        private readonly Category $category,
        private readonly Country $country,
    ) {}

    public function compose(View $view): void
    {
        $countries = Cache::rememberForever(Country::CACHE_KEY_ALL, function () {
            return $this->country->orderBy('name', 'asc')->get();
        });
        $view->with('countries', $countries);

        $categories = Cache::rememberForever(Category::CACHE_KEY_TOP_MENU, function () {
            return $this->category->where('top_menu', true)->orderBy('sort', 'asc')->get();
        });
        $view->with('categories', $categories);

        $order_fields = Cache::rememberForever(Listing::CACHE_KEY_ORDER_FIELDS, function () {
            return Listing::$order_fields;
        });
        $view->with('order_fields', $order_fields);
    }
}
