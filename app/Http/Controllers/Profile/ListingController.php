<?php

namespace App\Http\Controllers\Profile;

use App\Category;
use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Listing\StoreListingRequest;
use App\Http\Requests\Listing\UpdateListingRequest;
use App\Listing;
use App\Manufacturer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as ImageFacade;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::ForUser(Auth::user())
            ->orderBy('created_at', 'desc')
            ->simplePaginate(20);

        return view('profile.listing.index')->with(['listings' => $listings]);
    }

    public function create()
    {
        // $info = [];
        // $danger = [];

        // if (Auth::user()->hasVerifiedGA()) {
        //     if (Auth::user()->products()->count() >= config('product.limit_create_product_totp')) {
        //         $info[] = __('validation.limit_product_plan_totp');
        //     }
        // } else {
        //     if (Auth::user()->products()->count() >= config('product.limit_create_product')) {
        //         $danger[] = __('validation.limit_product_plan');
        //     }
        // }

        // if (! empty($info)) {
        //     return redirect()->route('profile.listings.index')
        //         ->withErrors($info, 'info')
        //         ->withErrors($danger, 'danger');
        // }
        // if (! empty($danger)) {
        //     return redirect()->route('profile.index')
        //         ->withErrors($info, 'info')
        //         ->withErrors($danger, 'danger');
        // }

        return view('profile.listing.create')->with([
            'products' => Product::all(),
            'countries' => Country::all(),
            // 'countries' => Country::orderBy('name', 'asc')->get(),
            // 'categories' => Category::orderBy('sort')->get(),
            // 'manufacturers' => Manufacturer::orderBy('sort')->get(),
        ]);

    }

    public function store(StoreListingRequest $request)
    {
        $listing = Listing::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'is_new' => $request->is_new,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'moq' => $request->moq,
            'serial_number' => $request->serial_number,
            'country_id' => $request->country_id,
            'description' => $request->description,
        ]);

        $category = Category::where('name', 'Hardware')->get();
        $listing->categories()->attach($category);

        if ($request->has('image')) {
            $image = $listing->images()->create([
                'link' => $request->file('image')->store('listings', 'public'),
            ]);
            $imageFacade = ImageFacade::make(public_path('storage/'.$image->link))->fit(1024, 1024, function ($constraint) {
                $constraint->upsize();
            });
            $imageFacade->save();
        }

        return redirect()->route('profile.listings.index')->with('success', 'New listing created');
    }

    public function show(Listing $listing)
    {
        //
    }

    public function edit(Listing $listing)
    {
        return view('profile.listing.edit')->with([
            'listing' => $listing,
            'products' => Product::all(),
            'countries' => Country::all(),
        ]);
    }

    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $listing->update([
            'product_id' => $request->product_id,
            'is_new' => $request->is_new,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'moq' => $request->moq,
            'serial_number' => $request->serial_number,
            'country_id' => $request->country_id,
            'description' => $request->description,
        ]);

        if ($request->has('image')) {
            foreach ($listing->images as $image) {
                $image->listings()->detach();
                $image->delete();
            }

            $image = $listing->images()->create([
                'link' => $request->file('image')->store('listings', 'public'),
            ]);
            $imageFacade = ImageFacade::make(public_path('storage/'.$image->link))->fit(1024, 1024, function ($constraint) {
                $constraint->upsize();
            });
            $imageFacade->save();
        }

        // if (!$listing->categories->where('id', $request->category)->first()) {
        //     $category = Category::find($request->category);
        //     if ($category) {
        //         $listing->categories()->detach();
        //         $listing->categories()->attach($category->id);
        //     }
        // }

        return redirect()->route('profile.listings.index')->with('success', 'Listing updated');
    }

    public function destroy(Listing $listing)
    {
        foreach ($listing->images as $image) {
            $image->listings()->detach();
            $image->delete();
        }

        $listing->delete();
        return redirect()->route('profile.listings.index')->with('success', 'Listing was deleted');
    }

    // public function verify(Request $request, Listing $listing)
    // {
    //     if (Auth::user()->can('update', $listing)) {
    //         if (in_array($listing->status, Listing::$status_not_change_edit)) {
    //             $listing->setStatus('moderation');
    //         }
    //         return redirect()->route('profile.listing.index')->with('success', __('product.messages.verify'));
    //     } else {
    //         return redirect()->back()->with('warning', '403 | This action is unauthorized');
    //     }
    // }

    // public function activate(Request $request, Listing $listing)
    // {
    //     if (Auth::user()->can('update', $listing)) {
    //         if (in_array($listing->status, ['moderated','canceled'])) {
    //             $listing->setStatus('active');
    //         }
    //         return redirect()->route('profile.listing.index')->with('success', __('product.messages.activated'));
    //     } else {
    //         return redirect()->back()->with('warning', '403 | This action is unauthorized');
    //     }
    // }

    // public function unpublish(Request $request, Listing $listing)
    // {
    //     if (Auth::user()->can('update', $listing)) {
    //         if (in_array($listing->status, ['active'])) {
    //             $listing->setStatus('canceled');
    //         }
    //         return redirect()->route('profile.listing.index')->with('success', __('product.messages.unpublish'));
    //     } else {
    //         return redirect()->back()->with('warning', '403 | This action is unauthorized');
    //     }
    // }
}