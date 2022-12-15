<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Category;
use App\Section;


class SettingsController extends Controller
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
            ]);
        }
    }
}
