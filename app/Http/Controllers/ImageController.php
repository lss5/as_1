<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function destroy(Image $image)
    {
        
        if (Storage::disk('public')->exists($image->link)) {
            Storage::disk('public')->delete($image->link);
        }

        $image->delete();
        return redirect()->route('products.edit', $image->product)->with('success', 'Image deleted');
    }
}
