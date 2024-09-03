<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Category;
use App\Section;
use App\Setting;
use App\Manufacturer;


class SettingController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('admin')) {
            // $products = Product::filter($filters)
            //     // ->withTrashed()
            //     ->orderBy('created_at', 'desc')
            //     ->simplePaginate(50);

            return view('admin.settings.index')->with([
                'categories' => Category::orderBy('sort')->get(),
                'sections' => Section::orderBy('sort')->get(),
                'manufacturers' => Manufacturer::orderBy('sort')->get(),
                'settings' => Setting::all(),
            ]);
        }
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:settings'],
            'value' => ['required', 'string'],
        ]);

        $setting = Setting::create($data);

        return redirect()->route('admin.settings.index')->with('success', 'Setting '.$setting->name.' created');
    }

    public function edit(Setting $setting)
    {
        return view('admin.settings.edit')->with(['setting' => $setting]);
    }

    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:settings,uniq_name,'.$setting->id],
            'value' => ['required', 'string'],
        ]);

        $setting->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Setting '.$setting->name.' updated');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Setting '.$setting->name.' deleted');
    }
}
