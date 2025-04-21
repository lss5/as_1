<?php

namespace App\Http\Controllers\Admin\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Property\StorePropertyValueRequest;
use App\Http\Requests\Admin\Property\UpdatePropertyValueRequest;
use App\Models\Property\Property;
use App\Models\Property\PropertyValue;
use Illuminate\Http\Request;

class PropertyValueController extends Controller
{
    public function index()
    {
        return view('admin.property-values.index', [
            'propertyValues' => PropertyValue::with('property')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.property-values.create', [
            'properties' => Property::query()->whereIn('value_type', Property::VALUE_TYPES)->get(),
        ]);
    }

    public function store(StorePropertyValueRequest $request)
    {
        $property = Property::findOrFail($request->get('property'));
        $propertyValue = $property->propertyValues()->create($request->validated());

        return redirect()->route('admin.property-values.index')->with('success', 'Property '.$propertyValue->value.' created');
    }

    public function show(PropertyValue $propertyValue)
    {
        return view('admin.property-values.show', [
            'propertyValue' => $propertyValue,
        ]);
    }

    public function edit(PropertyValue $propertyValue)
    {
        return view('admin.property-values.edit', [
            'propertyValue' => $propertyValue,
            'properties' => Property::query()->whereIn('value_type', Property::VALUE_TYPES)->get(),
        ]);
    }

    public function update(UpdatePropertyValueRequest $request, PropertyValue $propertyValue)
    {
        $propertyValue->update($request->validated());

        return redirect()->route('admin.property-values.index')->with('success', 'Property '.$propertyValue->value.' updated');
    }

    public function destroy(PropertyValue $propertyValue)
    {
        //
    }
}
