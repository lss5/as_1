<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProduct;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('product.index')->with([
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('product.create')->with([
            'product_images' => 0,
            'countries' => Country::all(),
        ]);
    }

    public function store(StoreProduct $request)
    {
        $validated = $request->validated();

        $country = Country::find($request->country);

        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->user_id = Auth::user()->id;
        $product->country()->associate($country);
        $product->save();
        // Product::create($request->only(['title', 'description']));

        return redirect()->route('products.images', $product)->with('success', 'New listing created');
    }

    public function show(Product $product)
    {
        return view('product.show')->with([
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        if (Auth::user()->can('update', $product))
        {
            return view('product.edit')->with([
                'product' => $product,
                'product_images' => $product->images->count(),
                'countries' => Country::all(),
            ]);
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function update(StoreProduct $request, Product $product)
    {
        if (Auth::user()->can('update', $product))
        {
            $validated = $request->validated();

            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                // 'active' => $active,
            ]);

            if ($product->country->id != $request->country) {
                $country = Country::find($request->country);
                $product->country()->associate($country);
                $product->save();
            }

            return redirect()->route('products.show', $product)->with('success', 'Listing updated');
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function addImage(Request $request, Product $product)
    {
        if (Auth::user()->can('update', $product))
        {
            $validatedData = $request->validate([
                'image' => 'required| file| image| max:3000',
            ]);

            $product->images()->create([
                'link' => $request->file('image')->store('products', 'public'),
            ]);

            return redirect()->route('products.images', $product)->with('success', 'Photo uploaded');
        }
    }

    public function destroy(Product $product)
    {
        return redirect()->route('products.show', $product)->with('danger', 'Listing deleted');
    }

    public function image(Product $product)
    {
        if (Auth::user()->can('update', $product))
        {
            return view('product.image')->with([
                'product' => $product,
                'product_images' => $product->images->count(),
            ]);
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function storeImage(Product $product, array $files)
    {
        foreach ($files as $key => $file) {
            $product->images()->create([
                'link' => $file->store('products', 'public'),
            ]);
        }

        return true;
    }
}
