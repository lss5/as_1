<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:categories'],
            'sort' => ['required', 'integer'],
        ]);

        $category = Category::create($data);

        return redirect()->route('admin.settings.index')->with('success', 'Category '.$category->name.' created');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit')->with(['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:categories,uniq_name,'.$category->id],
            'sort' => ['required', 'integer'],
        ]);

        $category->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Category '.$category->name.' updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Category '.$category->name.' deleted');
    }
}
