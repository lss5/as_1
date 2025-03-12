<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfile;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(User::class, 'user');
    // }

    public function index()
    {
        return view('admin.users.index')->with('users', User::all());
    }

    public function show(User $user)
    {
        return redirect()->route('profile.index')->with('warning', '403 | This action is unauthorized');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ])->with('warning', 'Warning! Dont edit Role' );
    }

    public function update(UpdateProfile $request, User $user)
    {
        $user->roles()->sync($request->roles);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->bio = $request->bio;
        if (is_null($request->verified)) {
            $user->user_verified_at = null;
        }
        $user->save();

        if ($user->country_id != $request->country) {
            $country = Country::find($request->country);
            $user->country()->associate($country);
            $user->save();
        }

        if (is_null($user->user_verified_at) && $request->verified == '1') {
            $user->markUserVerified();
        }

        return redirect()->route('admin.users.index')->with('success', 'User has been updated.');
    }

    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User has been deleted.');
    }
}
