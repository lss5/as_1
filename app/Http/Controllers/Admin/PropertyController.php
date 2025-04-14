<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Property\StorePropertyRequest;
use App\Http\Requests\Admin\Property\UpdatePropertyRequest;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        return view('admin.property.index', [
            'properties' => Property::all(),
        ]);
    }

    public function create()
    {
        return view('admin.property.create');
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Property::create($request->validated());

        return redirect()->route('admin.properties.index')->with('success', 'Property '.$property->title.' created');
    }

    public function edit(Property $property)
    {
        return view('admin.property.edit', [
            'property' => $property,
        ]);
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->validated());

        return redirect()->route('admin.properties.index')->with('success', 'Property '.$property->title.' updated');
    }

    public function destroy(Property $property)
    {
        //
    }
}
