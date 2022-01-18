<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as ImageFacade;

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
        return view('product.create')->with(['product_images' => 0]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['nullable', 'string', 'max:4096'],
            'image1' => ['sometimes','file','image','max:3000'],
            'image2' => 'sometimes|file|image|max:3000',
            'image3' => 'sometimes|file|image|max:3000',
        ]);

        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->user_id = Auth::user()->id;
        $product->save();
        // Product::create($request->only(['title', 'description']));

        $files = $request->allFiles();
        if (!empty($files)) {
            $this->storeImage($product, $files);
        }

        return redirect()->route('products.show', $product)->with('success', 'New listing created');
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
            ]);
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function update(Request $request, Product $product)
    {
        if (Auth::user()->can('update', $product))
        {
            $validatedData = $request->validate([
                'title' => ['required', 'string', 'min:5', 'max:255'],
                'description' => ['nullable', 'string', 'max:4096'],
                'image1' => ['sometimes','file','image','max:3000'],
                'image2' => 'sometimes|file|image|max:3000',
                'image3' => 'sometimes|file|image|max:3000',
            ]);

            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                // 'active' => $active,
            ]);

            $files = $request->allFiles();
            if (!empty($files)) {
                $this->storeImage($product, $files);
            }

            return redirect()->route('products.show', $product)->with('success', 'Listing updated');
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function destroy(Product $product)
    {
        return redirect()->route('products.show', $product)->with('danger', 'Listing deleted');
    }

    public function storeImage(Product $product, array $files)
    {
        foreach ($files as $key => $file) {
            $image_link = $file->store('products', 'public');
            $product->images()->create([
                'link' => $image_link,
            ]);
            $imageFacade = ImageFacade::make(public_path('storage/'.$image_link))->fit(500, 350, function ($constraint) {
                $constraint->upsize();
            });
            $imageFacade->save();
        }

        return true;
    }
}
