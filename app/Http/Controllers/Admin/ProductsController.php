<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Country;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Filters\ProductFilters;
use Carbon\Carbon;

class ProductsController extends Controller
{
    public function index(Request $request, ProductFilters $filters)
    {
        if (Auth::user()->can('viewAny', Product::class)) {
            $search = false;
            if ($request->anyFilled(['search', 'country', 'category', 'price', 'moq', 'power', 'hashrate', 'user', 'new'])) {
                $search = true;
            }

            $products = Product::filter($filters)
                ->withTrashed()
                ->orderBy('created_at', 'desc')
                ->simplePaginate(50);

            return view('product.admin.index')->with([
                'products' => $products,
                'countries' => Country::all(),
                'categories' => Category::all(),
                'searchForm' => $search,
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
            return redirect()->route('admin.products.index')->with('success', 'Product deleted');
        } else {
            return redirect()->back()->with('warning', 'You can`t delete is item');
        }
    }

    public function activate(Request $request, Product $product)
    {
        if (Auth::user()->can('restore', $product)) {
            $product->forceFill([
                'active_at' => Carbon::now()->addMonth(),
            ])->save();

            return redirect()->route('admin.products.index')->with('success', 'Product activated');
        } else {
            return redirect()->back()->with('warning', '403 | This action is unauthorized');
        }
    }

    public function restore(Request $request, $product)
    {
        $product = Product::withTrashed()->find($product);
        if (Auth::user()->can('restore', $product)) {
            $product->restore();
            return redirect()->route('admin.products.index')->with('success', 'Product restored');
        } else {
            return redirect()->back()->with('warning', '403 | This action is unauthorized');
        }
    }
}
