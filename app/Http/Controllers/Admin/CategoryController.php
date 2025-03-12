<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;

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
        return view('admin.category.create', [
            'properties' => Property::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
            'top_menu' => ['nullable'],
            'properties.*' => ['nullable', 'integer', 'exists:properties,id'],
        ]);

        if (isset($data['top_menu'])) {
            $data['top_menu'] = true;
        } else {
            $data['top_menu'] = false;
        }

        $category = Category::create($data);
        $category->properties()->sync($request->properties);

        return redirect()->route('admin.categories.index')->with('success', 'Category '.$category->name.' created');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit')->with([
            'category' => $category,
            'properties' => Property::orderBy('sort')->get(),
            'category_properties' => $category->properties()->orderBy('sort')->get()->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
            'top_menu' => ['nullable'],
            'properties.*' => ['nullable', 'integer', 'exists:properties,id'],
        ]);

        if (isset($data['top_menu'])) {
            $data['top_menu'] = true;
        } else {
            $data['top_menu'] = false;
        }

        $category->update($data);
        $category->properties()->sync($request->properties);

        return redirect()->route('admin.categories.index')->with('success', 'Category '.$category->name.' updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category '.$category->name.' deleted');
    }
}
