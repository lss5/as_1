<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
                'variables' => Setting::all(),
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

    public function edit(Setting $variable)
    {
        return view('admin.settings.edit')->with(['variable' => $variable]);
    }

    public function update(Request $request, Setting $variale)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:settings,uniq_name,'.$variale->id],
            'value' => ['required', 'string'],
        ]);

        $variale->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Setting '.$variale->name.' updated');
    }

    public function destroy(Setting $variable)
    {
        $variable->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Setting '.$variable->name.' deleted');
    }
}
