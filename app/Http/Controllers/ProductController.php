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
        // $errors = [];
        // if (!Auth::user()->hasVerifiedGA()) {
        //     $errors[] = __('validation.TOTP_authentication');
        // }

        // if (Auth::user()->contacts()->count() < 1) {
        //     $errors[] = __('validation.must_have_contact');
        // }

        // if (Auth::user()->products()->count() >= config('product.limit_create_listing')) {
        //     $errors[] = __('validation.limit_listing_plan');
        // }

        // if (!empty($errors)) {
        //     return redirect()->route('home.index')->withErrors($errors, 'danger');
        // }

        
        return view('product.create')->with([
            'product' => new Product,
            'product_images' => 0,
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

        return redirect()->route('products.edit', $product)->with('success', 'New listing created');
    }

    public function show(Product $product)
    {
        // Add count views page
        $product->increment('views');

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
