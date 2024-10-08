<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contracts\ImportData\NetworkPrice;
use App\Http\Requests\UpdateUser;
use App\Product;
use App\User;
use App\Country;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

class HomeController extends Controller
{
    public function index(NetworkPrice $networkPrice)
    {
        $networkPrice->setPrices();

        $popular = Product::active()
                ->has('images')
                ->orderBy('views', 'desc')
                ->limit(4)
                ->get();

        $newest = Product::active()
                ->has('images')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

        return view('main')->with([
            'popular' => $popular,
            'newest' => $newest,
            'prices' => $networkPrice->prices,
        ]);
    }

    public function home(Request $request)
    {
        return view('home.index')->with([
            'user' => Auth::user()->setLimitProduct(),
        ]);
    }

    public function products(Request $request)
    {
        $products = Product::ForUser(Auth::user())
                        ->orderBy('created_at', 'desc')
                        ->simplePaginate(12);

        return view('home.products')->with(['products' => $products]);
    }

    public function edit(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Auth::user()->can('update', $user)){
            return view('home.edit')->with(['user' => $user]);
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function update(UpdateUser $request, User $user)
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

            return redirect()->route('home.index')->with('success', 'Saved');
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function f2a(Request $request, User $user)
    {
        if (Auth::user()->can('update', $user)) {
            if ($user->hasVerifiedGA()) {
                return redirect()->route('home.index')->with('success', 'Your account enable 2-Step Verification');
            } else {
                $ga = new GoogleAuthenticator;
                if (empty($user->ga_secret)) {
                    $user->ga_secret = $ga->generateSecret();
                    $user->save();
                    $request->session()->flash('success', 'Secret key generated');
                }

                $url = GoogleQrUrl::generate('AsicOffer.com('.$user->email.')', $user->ga_secret);
            }

            return view('home.2fa')->with([
                'ga_url' => $url,
                'user' => $user,
            ]);
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function f2a_verify(Request $request, User $user)
    {
        if (Auth::user()->can('update', $user)) {
            if ($user->hasVerifiedGA()) {
                return redirect()->route('home.index')->with('warning', 'Your account enable 2-Step Verification');
            }
            $ga = new GoogleAuthenticator;
            $ga_code = $ga->getCode($user->ga_secret);
            if ($ga_code == $request->input('code')) {
                $user->markGAVerified();

                return redirect()->route('home.index')->with('success', '2-Step Verification enabled');
            } else {
                return redirect()->back()->with('warning', 'Code unmatch');
            }
        } else {
            return redirect()->back();
        }

    }
}
