<?php

namespace App\Http\Controllers;

use App\Filters\CategoryFilters;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category, CategoryFilters $filters)
    {
        $search = false;
        if ($request->anyFilled(['country', 'price', 'moq', 'power', 'hashrate', 'user', 'new'])) {
            $search = true;
        }

        $products = $category->products()
            ->filter($filters)
            ->orderBy('products.created_at', 'desc')
            ->simplePaginate(21);

        return view('category.index')->with([
            'category' => $category,
            'products' => $products,
            'countries' => Country::all(),
            'categories' => Category::orderBy('sort')->get(),
            'searchForm' => $search,
        ]);
    }
}
