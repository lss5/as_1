<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Gate;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function update(Request $request, User $user)
    {
        if (Auth::user()->can('update', $user))
        {
            $user->roles()->sync($request->roles);

            $user->email = $request->email;
            $user->name = $request->name;
            $user->save();
    
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
