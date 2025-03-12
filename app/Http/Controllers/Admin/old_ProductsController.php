<?php

namespace App\Http\Controllers\Admin;

use App\Filters\ProductFilters;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index(Request $request, ProductFilters $filters)
    {
        if (Auth::user()->can('moder')) {
            $search = false;
            if ($request->anyFilled(['search', 'country', 'category', 'price', 'moq', 'power', 'hashrate', 'user', 'new'])) {
                $search = true;
            }

            $products = Product::filter($filters)
                // ->withTrashed()
                ->orderBy('status_changed_at', 'desc')
                ->simplePaginate(50);

            return view('admin.products.index')->with([
                'products' => $products,
                'countries' => Country::orderBy('name', 'asc')->get(),
                'categories' => Category::orderBy('sort')->get(),
                'searchForm' => $search,
            ]);
        }

        return redirect()->route('profile.index')->with('warning', '403 | This action is unauthorized');
    }

    public function trashed(Request $request, ProductFilters $filters)
    {
        if (Auth::user()->can('moder')) {
            $search = false;
            if ($request->anyFilled(['search', 'country', 'category', 'price', 'moq', 'power', 'hashrate', 'user', 'new'])) {
                $search = true;
            }

            $products = Product::filter($filters)
                ->onlyTrashed()
                ->orderBy('created_at', 'desc')
                ->simplePaginate(50);

            return view('admin.products.index')->with([
                'products' => $products,
                'countries' => Country::orderBy('name', 'asc')->get(),
                'categories' => Category::orderBy('sort')->get(),
                'searchForm' => $search,
            ]);
        }

        return redirect()->route('profile.index')->with('warning', '403 | This action is unauthorized');
    }

    public function show(Product $product)
    {
        return view('product.admin.show')->with([
            'product' => $product,
        ]);
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

    public function restore(Request $request, $product)
    {
        $product = Product::withTrashed()->find($product);
        if (Auth::user()->can('restore', $product)) {
            if ($product->status != 'restored') {
                $product->restore();

                $product->fill([
                    'status' => 'restored',
                    'status_changed_at' => Carbon::now(),
                ])->save();
            }
            return redirect()->route('admin.products.index')->with('success', 'Product restored');
        } else {
            return redirect()->back()->with('warning', '403 | This action is unauthorized');
        }
    }

    // Statuses function
    public function set_status(Request $request, Product $product)
    {
        if (Auth::user()->can('delete', $product)) {
            $status = $request->input('status');
            if ($product->status != $status && in_array($status, Product::$statuses)) {
                $product->setStatus($status);
            } else {
                return redirect()->back()->with('warning', __('product.messages.status_not_changed'));
            }
            return redirect()->route('admin.products.index')->with('success', __('product.messages.status_changed'));
        } else {
            return redirect()->back()->withErrors(['403 | This action is unauthorized'], 'warning');
        }
    }
}
