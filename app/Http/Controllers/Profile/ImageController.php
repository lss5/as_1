<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (Auth::user()->can('update', $product))
        {
            $validatedData = $request->validate([
                'image' => 'required| file| image| max:3000| dimensions:min_width=500,min_height=300',
            ]);

            $product->images()->create([
                'link' => $request->file('image')->store('products', 'public'),
            ]);

            return redirect()->route('profile.listing.edit', $product)->with('success', 'Photo uploaded');
        }
    }

    public function destroy(Image $image)
    {
        if (Storage::disk('public')->exists($image->link)) {
            Storage::disk('public')->delete($image->link);
        }

        $image->delete();
        return redirect()->route('profile.listing.edit', $image->product)->with('success', 'Image deleted');
    }
}
