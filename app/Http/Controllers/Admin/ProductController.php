<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Algorithm;
use App\Models\Coin;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as ImageFacade;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at')->get();

        return view('admin.product.index')->with([
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('admin.product.create', [
            'manufacturers' => Manufacturer::all(),
            'algorithms' => Algorithm::all(),
            'coins' => Coin::all(),
            'coolings' => Product::$coolings,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'manufacturer' => ['required', 'integer', 'exists:manufacturers,id'],
            'model' => ['required', 'string'],
            'power' => ['nullable', 'integer', 'max:999999'],
            'hashrate' => ['nullable', 'integer', 'max:999999999'],
            'algorithms.*' => ['nullable', 'integer', 'exists:algorithms,id'],
            'coins.*' => ['nullable', 'integer', 'exists:coins,id'],
            'image' => ['nullable', 'file', 'image', 'max:5000', 'dimensions:min_width=500,min_height=500'],
        ]);

        $product = Product::create([
            'manufacturer_id' => $request->manufacturer,
            'model' => $request->model,
            'power' => $request->power,
            'hashrate' => $request->hashrate,
            'weight' => $request->weight,
            'cooling' => $request->cooling,
        ]);

        if ($request->has('image')) {
            $image = $product->images()->create([
                'link' => $request->file('image')->store('products', 'public'),
            ]);

            $imageFacade = ImageFacade::make(public_path('storage/'.$image->link))->fit(1024, 1024, function ($constraint) {
                $constraint->upsize();
            });
            $imageFacade->save();
        }

        $product->algorithms()->sync($request->algorithms);
        $product->coins()->sync($request->coins);

        return redirect()->route('admin.products.index')->with('success', 'Product '.$product->model.' created');
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'product' => $product,
            'manufacturers' => Manufacturer::all(),
            'algorithms' => Algorithm::all(),
            'coins' => Coin::all(),
            'coolings' => Product::$coolings,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'manufacturer' => ['required', 'integer', 'exists:manufacturers,id'],
            'model' => ['required', 'string'],
            'power' => ['nullable', 'integer', 'max:999999'],
            'hashrate' => ['nullable', 'integer', 'max:999999999'],
            'algorithms.*' => ['nullable', 'integer', 'exists:algorithms,id'],
            'coins.*' => ['nullable', 'integer', 'exists:coins,id'],
            'image' => ['nullable', 'file', 'image', 'max:5000', 'dimensions:min_width=500,min_height=300'],
        ]);

        $product->update([
            'manufacturer_id' => $request->manufacturer,
            'model' => $request->model,
            'power' => $request->power,
            'hashrate' => $request->hashrate,
            'weight' => $request->weight,
            'cooling' => $request->cooling,
        ]);

        if ($request->has('image')) {
            foreach ($product->images as $image) {
                $image->products()->detach();
                $image->delete();
            }

            $image = $product->images()->create([
                'link' => $request->file('image')->store('products', 'public'),
            ]);
            $imageFacade = ImageFacade::make(public_path('storage/'.$image->link))->fit(1024, 1024, function ($constraint) {
                $constraint->upsize();
            });
            $imageFacade->save();
        }

        $product->algorithms()->sync($request->algorithms);
        $product->coins()->sync($request->coins);

        return redirect()->route('admin.products.index')->with('success', 'Product '.$product->model.' updated');
    }

    public function destroy(Product $product)
    {
        $product->algorithms()->detach();
        $product->coins()->detach();

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product '.$product->model.' deleted');
    }
}
