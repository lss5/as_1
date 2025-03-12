<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Property;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'unit' => ['nullable', 'string'],
            'sort' => ['nullable', 'integer'],
        ]);

        $property = Property::create($validated);

        return redirect()->route('admin.properties.index')->with('success', 'Property '.$property->title.' created');
    }

    public function edit(Property $property)
    {
        return view('admin.property.edit', [
            'property' => $property,
        ]);
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'unit' => ['nullable', 'string'],
            'sort' => ['nullable', 'integer'],
        ]);

        $property->update($validated);

        return redirect()->route('admin.properties.index')->with('success', 'Property '.$property->title.' updated');
    }

    public function destroy(Property $property)
    {
        //
    }
}
