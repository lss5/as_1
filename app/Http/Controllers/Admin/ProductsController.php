<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->can('viewAny', Product::class)) {
            $products = Product::orderBy('created_at', 'desc')->get();

            return view('product.admin.index')->with([
                'products' => $products,
            ]);
        }

        return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
    }

    public function show(Product $product)
    {
        return view('product.admin.show')->with([
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        return redirect()->back();
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        if (Auth::user()->can('delete', $product)) {
            foreach ($product->images as $image) {
                $image->delete();
            }
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Product was deleted');
        } else {
            return redirect()->back()->with('warning', 'You can`t delete is item');
        }
    }
}
