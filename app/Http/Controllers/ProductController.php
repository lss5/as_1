<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use App\Country;
use App\Category;
use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Filters\ProductFilters;
use App\Http\Requests\StoreProduct;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

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
                ->whereDate('active_at', '>', Carbon::now())
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
        $errors = [];
        if (!Auth::user()->hasVerifiedGA()) {
            $errors[] = __('validation.TOTP_authentication');
        }

        if (Auth::user()->contacts()->count() < 1) {
            $errors[] = __('validation.must_have_contact');
        }

        if (Auth::user()->products()->count() >= config('product.limit_create_listing')) {
            $errors[] = __('validation.limit_listing_plan');
        }

        if (!empty($errors)) {
            return redirect()->route('home.index')->withErrors($errors, 'danger');
        }

        
        return view('product.create')->with([
            'product' => new Product,
            'product_images' => 0,
            'countries' => Country::all(),
            'categories' => Category::all(),
        ]);
    }

    public function store(StoreProduct $request)
    {
        $country = Country::find($request->country);
        $category = Category::find($request->category);

        $product = new Product();
        $product->title = Str::of($request->title)->ucfirst();
        $product->description = Str::of($request->description)->trim();
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->moq = $request->moq;
        $product->power = $request->power;
        $product->hashrate = $request->hashrate;
        $product->hashrate_name = $request->hashrateName;
        $product->isnew = $request->has('condition') ? 1 : 0;
        $product->user_id = Auth::user()->id;
        $product->country()->associate($country);

        $product->fill_profit();
        $product->save();
        $product->categories()->attach($category->id);

        return redirect()->route('products.edit', $product)->with('success', 'New listing created');
    }

    public function show(Product $product)
    {
        // Add count views page
        $product->increment('views');

        if (empty($product->mining_timestamp)) {
            $product->fill_profit();
            $product->save();
        } elseif (Carbon::parse($product->mining_timestamp)->diffInMinutes(now('UTC')) > 60) { // TODO: diff minutes in .env (60)
            $product->fill_profit();
            $product->save();
        }
        // TODO: transfer profit calculate here from blade

        return view('product.show')->with([
            'product' => $product,
        ]);
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

    public function update(StoreProduct $request, Product $product)
    {
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'moq' => $request->moq,
            'power' => $request->power,
            'hashrate' => $request->hashrate,
            'hashrate_name' => $request->hashrateName,
            'isnew' => $request->has('condition') ? 1 : 0,
        ]);

        $product->fill_profit();
        $product->save();

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

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            $image->delete();
        }
        $product->delete();
        return redirect()->route('home.listings')->with('success', 'Product was deleted');
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

    public function reactivate(Request $request, Product $product)
    {
        if (Auth::user()->can('update', $product)) {
            if(!is_null($product->active_at) && $product->active_at < Carbon::now()) {
                $product->forceFill([
                    'active_at' => Carbon::now()->addMonths(2),
                ])->save();
            }

            return redirect()->route('home.listings')->with('success', 'Product republished');
        } else {
            return redirect()->back()->with('warning', '403 | This action is unauthorized');
        }
    }
}
