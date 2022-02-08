<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use App\Country;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProduct;
use Illuminate\Support\Str;
use App\Filters\ProductFilters;

class ProductController extends Controller
{

    public function index(Request $request, ProductFilters $filters)
    {
        // if (empty($request->get('order'))) {
        //     $request->request->add(['order' => 'price']);
        // }

        // Open search form
        $search = false;
        if ($request->anyFilled(['search', 'country', 'category', 'price', 'moq', 'power', 'hashrate', 'user', 'new'])) {
            $search = true;
        }

        $products = Product::filter($filters)
                ->where('active', 1)
                ->orderBy('products.created_at', 'desc')
                ->simplePaginate(21);

        return view('product.index')->with([
            'products' => $products,
            'countries' => Country::all(),
            'categories' => Category::all(),
            'searchForm' => $search,
        ]);
    }

    public function create()
    {
        return view('product.create')->with([
            'product' => new Product,
            'product_images' => 0,
            'countries' => Country::all(),
            'categories' => Category::all(),
        ]);
    }

    public function store(StoreProduct $request)
    {
        $validated = $request->validated();

        $country = Country::find($request->country);
        $category = Category::find($request->category);

        $product = new Product;
        $product->title = Str::of($request->title)->ucfirst();
        $product->description = Str::of($request->description)->trim();
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->moq = $request->moq;
        $product->power = $request->power;
        $product->hashrate = $request->hashrate;
        $product->hashrate_name = $request->hashrateName;
        $product->active = $request->has('active') ? 1 : 0;
        $product->isnew = $request->has('condition') ? 1 : 0;
        $product->user_id = Auth::user()->id;
        $product->country()->associate($country);
        $product->save();
        $product->categories()->attach($category->id);

        return redirect()->route('products.images', $product)->with('success', 'New listing created');
    }

    public function show(Product $product)
    {
        $product->increment('views');
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
                'categories' => Category::all(),
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
                'quantity' => $request->quantity,
                'moq' => $request->moq,
                'power' => $request->power,
                'hashrate' => $request->hashrate,
                'hashrate_name' => $request->hashrateName,
                'active' => $request->has('active') ? 1 : 0,
                'isnew' => $request->has('condition') ? 1 : 0,
            ]);

            if ($product->country->id != $request->country) {
                $country = Country::find($request->country);
                $product->country()->associate($country);
                $product->save();
            }

            if (!$product->categories->where('id', $request->category)->first()) {
                $category = Category::find($request->category);
                if ($category) {
                    $product->categories()->detach();
                    $product->categories()->attach($category->id);
                }
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
