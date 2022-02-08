<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Country;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Filters\ProductFilters;

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
            return redirect()->route('admin.products.index')->with('success', 'Product was deleted');
        } else {
            return redirect()->back()->with('warning', 'You can`t delete is item');
        }
    }
}
