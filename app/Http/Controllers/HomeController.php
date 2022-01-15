<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // $request->session()->flash('success', 'Home action');
        return view('home');
    }

    public function index()
    {
        return view('welcome');
    }
}
