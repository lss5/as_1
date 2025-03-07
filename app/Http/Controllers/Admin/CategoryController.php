<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort')->get();
        return view('admin.category.index')->with([
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
            'top_menu' => ['nullable'],
        ]);
        if (isset($data['top_menu'])) {
            $data['top_menu'] = 1;
        } else {
            $data['top_menu'] = 0;
        }

        $category = Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category '.$category->name.' created');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit')->with(['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
            'top_menu' => ['nullable'],
        ]);
        if (isset($data['top_menu'])) {
            $data['top_menu'] = 1;
        } else {
            $data['top_menu'] = 0;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category '.$category->name.' updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category '.$category->name.' deleted');
    }
}
