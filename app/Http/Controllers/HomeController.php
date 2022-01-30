<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\User;
use App\Country;
use App\Http\Requests\UpdateUser;

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

    public function settings(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Auth::user()->can('update', $user)){
            return view('home.settings')->with(['user' => $user]);
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function setting(UpdateUser $request, User $user)
    {
        if (Auth::user()->can('update', $user))
        {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->bio = $request->bio;
            $user->save();

            if ($user->country_id != $request->country) {
                $country = Country::find($request->country);
                $user->country()->associate($country);
                $user->save();
            }

            return redirect()->route('home.settings')->with('success', 'Saved');
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }

    }
}
// ->middleware('can:update,user')