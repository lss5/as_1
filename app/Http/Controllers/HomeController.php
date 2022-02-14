<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

use App\Product;
use App\User;
use App\Country;
use App\Http\Requests\UpdateUser;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

class HomeController extends Controller
{
    public function home(Request $request, $id = null)
    {
        $user = User::find($id);

        if($user) {
            if (Auth::user()->cannot('view', $user)) {
                $user = Auth::user();
            }
        } else {
            $user = Auth::user();
        }

        return view('home.index')->with([
            'user' => $user,
        ]);
    }

    public function index()
    {
        $popular = Product::whereDate('active_at', '>', Carbon::now())
                ->has('images')
                ->orderBy('views', 'desc')
                ->limit(4)
                ->get();

        $newest = Product::whereDate('active_at', '>', Carbon::now())
                ->has('images')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

        return view('welcome')->with([
            'popular' => $popular,
            'newest' => $newest,
        ]);
    }

    public function listings(Request $request)
    {
        $access = Gate::inspect('create', Product::class);
        if ($access->allowed()) {

        } else {
            $request->session()->flash('warning', $access->message());
        }

        $listings = Product::where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->simplePaginate(9);

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

    public function contact(Request $request, User $user)
    {
        if (Auth::user()->can('update', $user)){
            foreach ($user->contacts as $contact) {
                $contact->ismain = false;
                $contact->save();
            }

            $user->contacts()->create([
                'value' => $request->value,
                'type' => $request->type,
            ]);

            return redirect()->route('home.settings')->with('success', 'Contact saved');
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

                $url = GoogleQrUrl::generate('AsicSeller.com('.$user->email.')', $user->ga_secret);
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
