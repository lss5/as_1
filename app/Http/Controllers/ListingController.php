<?php

namespace App\Http\Controllers;

use App\Filters\ListingFilters;
use App\Models\Category;
use App\Models\Country;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request, ListingFilters $filters)
    {
        // Open search form
        $search = false;
        if ($request->anyFilled(['search', 'country', 'price_min', 'price_max', 'moq', 'hashrate', 'new'])) {
            $search = true;
        }

        $listing = Listing::filter($filters)
                // ->active()
                ->orderBy('listings.created_at', 'desc')
                ->simplePaginate(21);

        return view('listing.index')->with([
            'listings' => $listing,
            'countries' => Country::all(),
            'categories' => Category::orderBy('sort')->get(),
            'searchForm' => $search,
        ]);
    }

    public function show(Listing $listing)
    {
        // Add count views page
        // $listing->increment('views');

        if (!empty($listing->power)) {
            $listing->cost = round($listing->product->power * 0.06 * 24 / 1000, 2);
            $listing->profit = round($listing->revenue - ($listing->product->power * 0.06 * 24 / 1000), 2);
        }

        return view('listing.show')->with([
            'listing' => $listing,
        ]);
    }

    public function user(User $user)
    {
        return view('Listing.user')->with([
            'user' => $user,
            'listings' => Listing::ForUser($user)->active()->get(),
        ]);
    }
}
