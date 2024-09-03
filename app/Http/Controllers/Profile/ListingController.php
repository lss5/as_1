<?php

namespace App\Http\Controllers\Profile;

use App\Category;
use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Listing\StoreListingRequest;
use App\Http\Requests\Listing\UpdateListingRequest;
use App\Listing;
use App\Manufacturer;
// use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::ForUser(Auth::user())
            ->orderBy('created_at', 'desc')
            ->simplePaginate(12);

        return view('profile.listings.index')->with(['products' => $listings]);
    }

    public function create()
    {
        $info = [];
        $danger = [];

        if (Auth::user()->hasVerifiedGA()) {
            if (Auth::user()->products()->count() >= config('product.limit_create_product_totp')) {
                $info[] = __('validation.limit_product_plan_totp');
            }
        } else {
            if (Auth::user()->products()->count() >= config('product.limit_create_product')) {
                $danger[] = __('validation.limit_product_plan');
            }
        }

        // if (! empty($info)) {
        //     return redirect()->route('profile.listing.index')
        //         ->withErrors($info, 'info')
        //         ->withErrors($danger, 'danger');
        // }
        // if (! empty($danger)) {
        //     return redirect()->route('profile.index')
        //         ->withErrors($info, 'info')
        //         ->withErrors($danger, 'danger');
        // }

        return view('profile.listings.create')->with([
            'countries' => Country::orderBy('name', 'asc')->get(),
            'categories' => Category::orderBy('sort')->get(),
            'manufacturers' => Manufacturer::orderBy('sort')->get(),
        ]);

    }

    public function store(StoreListingRequest $request)
    {
        $listing = Listing::create($request->validated());
        $listing->categories()->attach($request->category);
        $listing->images()->create([
            'link' => $request->file('image')->store('products', 'public'),
        ]);

        return redirect()->route('profile.listing.index')->with('success', 'New listing created');
    }

    public function show(Listing $listing)
    {
        //
    }

    public function edit(Listing $listing)
    {
        return view('profile.listings.edit')->with([
            'product' => $listing,
            'product_images' => $listing->images->count(),
            'countries' => Country::orderBy('name', 'asc')->get(),
            'categories' => Category::orderBy('sort')->get(),
            'manufacturers' => Manufacturer::orderBy('sort')->get(),
        ]);
    }

    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $listing->update($request->validated());

        if ($listing->country->id != $request->country) {
            $country = Country::find($request->country);
            $listing->country()->associate($country);
            $listing->save();
        }

        if (!$listing->categories->where('id', $request->category)->first()) {
            $category = Category::find($request->category);
            if ($category) {
                $listing->categories()->detach();
                $listing->categories()->attach($category->id);
            }
        }

        return redirect()->route('profile.listing.index')->with('success', 'Listing updated');
    }

    public function destroy(Listing $listing)
    {
        foreach ($listing->images as $image) {
            $image->delete();
        }
        $listing->delete();
        return redirect()->route('profile.listing.index')->with('success', 'Listing was deleted');
    }

    public function verify(Request $request, Listing $listing)
    {
        if (Auth::user()->can('update', $listing)) {
            if (in_array($listing->status, Listing::$status_not_change_edit)) {
                $listing->setStatus('moderation');
            }
            return redirect()->route('profile.listing.index')->with('success', __('product.messages.verify'));
        } else {
            return redirect()->back()->with('warning', '403 | This action is unauthorized');
        }
    }

    public function activate(Request $request, Listing $listing)
    {
        if (Auth::user()->can('update', $listing)) {
            if (in_array($listing->status, ['moderated','canceled'])) {
                $listing->setStatus('active');
            }
            return redirect()->route('profile.listing.index')->with('success', __('product.messages.activated'));
        } else {
            return redirect()->back()->with('warning', '403 | This action is unauthorized');
        }
    }

    public function unpublish(Request $request, Listing $listing)
    {
        if (Auth::user()->can('update', $listing)) {
            if (in_array($listing->status, ['active'])) {
                $listing->setStatus('canceled');
            }
            return redirect()->route('profile.listing.index')->with('success', __('product.messages.unpublish'));
        } else {
            return redirect()->back()->with('warning', '403 | This action is unauthorized');
        }
    }
}
