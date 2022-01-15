<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('product.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['nullable', 'string', 'max:4096'],
        ]);

        $product = new Product;

        $product->title = $request->title;
        $product->description = $request->description;
        $product->user_id = Auth::user()->id;

        $product->save();

        return redirect()->route('products.show', $product)->with('success', 'New advert created!');
    }

    public function show(Product $product)
    {
        return view('product.show')->with([
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
