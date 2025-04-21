<?php

namespace App\Http\Controllers\Admin\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Property\StorePropertyRequest;
use App\Http\Requests\Admin\Property\UpdatePropertyRequest;
use App\Models\Category;
use App\Models\Property\Property;

class PropertyController extends Controller
{
    public function index()
    {
        return view('admin.property.index', [
            'properties' => Property::with('categories:name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.property.create', [
            'categories' => Category::all(),
            'value_types' => Property::VALUE_TYPES,
        ]);
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Property::create($request->safe()->only(['title','unit','sort','value_type']));
        $property->categories()->sync($request->get('categories'));

        return redirect()->route('admin.properties.index')->with('success', 'Property '.$property->title.' created');
    }

    public function edit(Property $property)
    {
        return view('admin.property.edit', [
            'property' => $property,
            'categories' => Category::all(),
            'value_types' => Property::VALUE_TYPES,
            'property_categories' => $property->categories->pluck('id')->toArray(),
        ]);
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->safe()->only(['title','unit','sort','value_type']));
        $property->categories()->sync($request->get('categories'));

        return redirect()->route('admin.properties.index')->with('success', 'Property '.$property->title.' updated');
    }

    public function destroy(Property $property)
    {
        //
    }
}
