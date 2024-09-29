<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Filters\ListingFilters;
use App\Listing;
use App\Country;
use App\Category;
use App\User;
use App\Manufacturer;

class ListingController extends Controller
{
    // use SoftDeletes;

    // public function __construct()
    // {
    //     $this->authorizeResource(Listing::class, 'Listing');
    // }

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
        $listing->increment('views');

        if (!empty($listing->power)) {
            $listing->cost = round($listing->power * 0.06 * 24 / 1000, 2);
            $listing->profit = round($listing->revenue - ($listing->power * 0.06 * 24 / 1000), 2);
        }

        return view('listing.show')->with([
            'listing' => $listing,
        ]);
    }

    // public function storeImage(Listing $listing, array $files)
    // {
    //     foreach ($files as $key => $file) {
    //         $listing->images()->create([
    //             'link' => $file->store('listings', 'public'),
    //         ]);
    //     }

    //     return true;
    // }

    public function user(User $user)
    {
        return view('Listing.user')->with([
            'user' => $user,
            'listings' => Listing::ForUser($user)->active()->get(),
        ]);
    }

}
