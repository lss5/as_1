<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Product;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // $request->session()->flash('success', 'Home action');
        return view('home.index');
    }

    public function index()
    {
        return view('welcome');
    }

    public function listings(Request $request)
    {
        $listings = Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('home.listing')->with(['products' => $listings]);
    }
}
