<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Manufacturer;
use App\Country;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::orderBy('sort')->get();
        return view('admin.manufacturer.index')->with([
            'manufacturers' => $manufacturers,
        ]);
    }

    public function create()
    {
        return view('admin.manufacturer.create')->with([
            'countries' => Country::orderBy('name', 'asc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'url' => ['nullable', 'string'],
            'sort' => ['required', 'integer'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
        ]);

        $manufacturer = Manufacturer::create($data);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Category '.$manufacturer->name.' created');
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('admin.manufacturer.edit')->with([
            'manufacturer' => $manufacturer,
            'countries' => Country::orderBy('name', 'asc')->get(),
        ]);
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'url' => ['nullable', 'string'], // 'unique:manufacturers,uniq_name,'.$manufacturer->id],
            'sort' => ['required', 'integer'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
        ]);

        $manufacturer->update($data);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer '.$manufacturer->name.' updated');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer '.$manufacturer->name.' deleted');
    }
}
