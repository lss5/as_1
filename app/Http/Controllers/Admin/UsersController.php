<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Country;
use Gate;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\UpdateUser;

class UsersController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(User::class, 'user');
    // }

    public function index()
    {
        if (Auth::user()->can('viewAny', User::class)) {
            $users = User::all();
            return view('users.index')->with('users', $users);
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function show(User $user)
    {
        if (Auth::user()->can('view', $user)) {
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function edit(User $user)
    {
        if (Auth::user()->can('update', $user))
        {
            $roles = Role::all();
    
            return view('users.edit')->with([
                'user' => $user,
                'roles' => $roles,
            ])->with('warning', 'Warning! Dont edit Role' );
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function update(UpdateUser $request, User $user)
    {
        if (Auth::user()->can('update', $user))
        {
            $user->roles()->sync($request->roles);

            if (Auth::user()->can('restore', $user)) {
                $user->email = $request->email;
                $user->name = $request->name;
            }
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
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }

    }

    public function destroy(User $user)
    {
        if (Auth::user()->can('delete', $user))
        {
            $user->roles()->detach();
            $user->delete();
    
            return redirect()->route('admin.users.index')->with('success', 'User has been deleted.');
        } else {
            return redirect()->route('home.index')->with('warning', '403 | This action is unauthorized');
        }
    }
}
