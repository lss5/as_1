<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Listing;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        return view('admin.listing.index', ['listings' => Listing::orderBy('created_at', 'asc')->get()]);
    }

    public function show(Listing $listing)
    {
        return view('admin.listing.show', [
            'listing' => $listing,
            'statuses' => Status::all(),
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'status' => ['required', 'integer', 'exists:statuses,id'],
        ]);

        if ($listing->status->id !== $validated['status']) {
            $listing->update([
                'status_id' => $validated['status'],
                'status_changed_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('admin.listings.index')->with('success', 'Status changed');
    }

    public function destroy(Listing $listing)
    {
        //
    }
}
