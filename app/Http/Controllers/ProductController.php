<?php

namespace App\Http\Controllers;

use App\Product;
use App\Country;
use App\Category;
use App\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Filters\ProductFilters;
use App\Jobs\ProductProfitFillJob;
use App\Notifications\ProductCreatedNotification;


class ProductController extends Controller
{
    use SoftDeletes;

    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(Request $request, ProductFilters $filters)
    {
        // Open search form
        $search = false;
        if ($request->anyFilled(['search', 'country', 'category', 'price', 'moq', 'power', 'hashrate', 'user', 'new'])) {
            $search = true;
        }

        $products = Product::filter($filters)
                ->where('status', '=', 'active')
                // ->whereDate('active_at', '>', Carbon::now())
                ->orderBy('products.created_at', 'desc')
                ->simplePaginate(21);

        return view('product.index')->with([
            'products' => $products,
            'countries' => Country::all(),
            'categories' => Category::all(),
            'searchForm' => $search,
        ]);
    }

    public function show(Product $product)
    {
        // Add count views page
        $product->increment('views');

        if (!empty($product->power)) {
            $product->cost = round($product->power * 0.06 * 24 / 1000, 2);
            $product->profit = round($product->revenue - ($product->power * 0.06 * 24 / 1000), 2);
        }

        return view('product.show')->with([
            'product' => $product,
        ]);
    }

    public function create()
    {
        $info = [];
        $danger = [];

        if (Auth::user()->hasVerifiedGA()) {
            if (Auth::user()->products()->count() >= config('product.limit_create_product_totp')) {
                $info[] = __('validation.limit_product_plan_totp');
            }
        } else {
            if (Auth::user()->products()->count() >= config('product.limit_create_product')) {
                $danger[] = __('validation.limit_product_plan');
            }
        }

        if (!empty($info)) {
            return redirect()->route('home.products')
                ->withErrors($info, 'info')
                ->withErrors($danger, 'danger');
        }
        if (!empty($danger)) {
            return redirect()->route('home.index')
                ->withErrors($info, 'info')
                ->withErrors($danger, 'danger');
        }

        return view('product.create')->with([
            'countries' => Country::all(),
            'categories' => Category::all(),
        ]);

    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->categories()->attach($request->category);
        $product->images()->create([
            'link' => $request->file('image')->store('products', 'public'),
        ]);

        ProductProfitFillJob::dispatch($product);
        $product->user->notify(new ProductCreatedNotification($product));

        return redirect()->route('home.products')->with('success', 'New listing created');
        // return redirect()->route('products.edit', $product)->with('success', 'New listing created');
    }

    public function edit(Product $product)
    {
        return view('product.edit')->with([
            'product' => $product,
            'product_images' => $product->images->count(),
            'countries' => Country::all(),
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        ProductProfitFillJob::dispatch($product);

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

        return redirect()->route('home.products')->with('success', 'Listing updated');
        // return redirect()->route('products.show', $product)->with('success', 'Listing updated');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            $image->delete();
        }
        $product->delete();
        return redirect()->route('home.products')->with('success', 'Product was deleted');
    }

    public function addImage(Request $request, Product $product)
    {
        if (Auth::user()->can('update', $product))
        {
            $validatedData = $request->validate([
                'image' => 'required| file| image| max:3000| dimensions:min_width=500,min_height=300',
            ]);

            $product->images()->create([
                'link' => $request->file('image')->store('products', 'public'),
            ]);

            return redirect()->route('products.edit', $product)->with('success', 'Photo uploaded');
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

    public function user(User $user)
    {
        return view('product.user')->with([
            'user' => $user,
        ]);
    }
}
