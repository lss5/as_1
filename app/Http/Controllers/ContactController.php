<?php

namespace App\Http\Controllers;

use App\Contact;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, User $user)
    {
        if (Auth::user()->can('update', $user))
        {
            $request->validate([
                'value' => ['required', 'string', 'max:30'],
                'type' => ['required', 'string', Rule::in(array_keys(Contact::$types)),],
            ]);

            foreach ($user->contacts as $contact) {
                $contact->update([
                    'ismain' => false,
                ]);
            }

            $user->contacts()->create([
                'value' => $request->value,
                'type' => $request->type,
            ]);

            return redirect()->route('profile.index')->with('success', 'Contact saved');
        } else {
            return redirect()->route('profile.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function setmain(Contact $contact)
    {
        if (Auth::user()->can('update', $contact))
        {
            foreach ($contact->user->contacts()->where('ismain', true)->get() as $notmain) {
                $notmain->update([
                    'ismain' => false,
                ]);
            }

            $contact->update([
                'ismain' => true,
            ]);

            return redirect()->route('profile.index')->with('success', 'Contact set is main');
        } else {
            return redirect()->route('profile.index')->with('warning', '403 | This action is unauthorized');
        }
    }

    public function edit(Contact $contact)
    {
        //
    }

    public function update(Request $request, Contact $contact)
    {
        //
    }

    public function destroy(Contact $contact)
    {
        if (Auth::user()->can('delete', $contact))
        {
            if ($contact->ismain) {
                $main = $contact->user->contacts()->first();
                $main->update([
                    'ismain' => true,
                ]);
            }
            $contact->user()->dissociate();
            $contact->delete();

            return redirect()->route('profile.index')->with('success', 'Contact deleted');
        } else {
            return redirect()->route('profile.index')->with('warning', '403 | This action is unauthorized');
        }
    }
}
