<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfile;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as ImageFacade;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $sum_listings = $user->listings()->count();
        $active_listings = Listing::forUser($user)->statusActive()->count();

        return view('profile.index')->with([
            'user' => $user, //->setLimitProduct(),
            'contacts' => Contact::forUser($user)->orderBy('ismain', 'desc')->get(),
            'sum_listings' => $sum_listings,
            'active_listings' => $active_listings,
            'company' => Company::forUser($user)->first(),
        ]);
    }

    public function update(UpdateProfile $request, User $user)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->bio = $request->bio;
        $user->payments = $request->payments;
        $user->save();

        if ($user->country_id != $request->country) {
            $country = Country::find($request->country);
            $user->country()->associate($country);
            $user->save();
        }

        return redirect()->route('profile.index')->with('success', 'Information saved');
    }

    public function update_image(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'photo' => 'required| file| image| max:3000| dimensions:min_width=500,min_height=300',
        ]);

        foreach ($user->images as $image) {
            $image->users()->detach();
            $image->delete();
        }

        $photo = $user->images()->create([
            'link' => $request->file('photo')->store('profile', 'public'),
        ]);

        $imageFacade = ImageFacade::make(public_path('storage/'.$photo->link))->fit(256, 256, function ($constraint) {
            $constraint->upsize();
        });

        $imageFacade->save();

        return redirect()->route('profile.index')->with('success', 'Photo updated');
    }

    // public function f2a(Request $request, User $user)
    // {
    //     if (Auth::user()->can('update', $user)) {
    //         if ($user->hasVerifiedGA()) {
    //             return redirect()->route('profile.index')->with('success', 'Your account enable 2-Step Verification');
    //         } else {
    //             $ga = new GoogleAuthenticator;
    //             if (empty($user->ga_secret)) {
    //                 $user->ga_secret = $ga->generateSecret();
    //                 $user->save();
    //                 $request->session()->flash('success', 'Secret key generated');
    //             }

    //             $url = GoogleQrUrl::generate('AsicSeller.com('.$user->email.')', $user->ga_secret);
    //         }

    //         return view('home.2fa')->with([
    //             'ga_url' => $url,
    //             'user' => $user,
    //         ]);
    //     } else {
    //         return redirect()->route('profile.index')->with('warning', '403 | This action is unauthorized');
    //     }
    // }

    // public function f2a_verify(Request $request, User $user)
    // {
    //     if (Auth::user()->can('update', $user)) {
    //         if ($user->hasVerifiedGA()) {
    //             return redirect()->route('profile.index')->with('warning', 'Your account enable 2-Step Verification');
    //         }
    //         $ga = new GoogleAuthenticator;
    //         $ga_code = $ga->getCode($user->ga_secret);
    //         if ($ga_code == $request->input('code')) {
    //             $user->markGAVerified();

    //             return redirect()->route('profile.index')->with('success', '2-Step Verification enabled');
    //         } else {
    //             return redirect()->back()->with('warning', 'Code unmatch');
    //         }
    //     } else {
    //         return redirect()->back();
    //     }

    // }
}
