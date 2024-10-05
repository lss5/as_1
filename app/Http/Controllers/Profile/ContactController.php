<?php

namespace App\Http\Controllers\Profile;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    public function index()
    {
        return view('profile.contact.index', [
            'contacts' => Contact::forUser(Auth::user())->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function create()
    {
        return view('profile.contact.create', [
            'types' => Contact::$types,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(array_keys(Contact::$types))],
            'main' => 'nullable',
        ]);

        $user = Auth::user();

        if ($request->main) {
            foreach ($user->contacts as $contact) {
                $contact->update([
                    'ismain' => false,
                ]);
            }
        }

        $contact = $user->contacts()->create([
            'value' => $request->value,
            'type' => $request->type,
            'ismain' => $request->main ? true : false,
        ]);

        return redirect()->route('profile.contacts.index')->with('success', 'Contact saved');
    }

    public function edit(Contact $contact)
    {
        return view('profile.contact.edit', [
            'contact' => $contact,
            'types' => Contact::$types,
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(array_keys(Contact::$types))],
            'main' => 'nullable',
        ]);

        $user = Auth::user();

        if ($request->main) {
            foreach ($user->contacts as $contact) {
                $contact->update([
                    'ismain' => false,
                ]);
            }
        }

        $contact->update([
            'value' => $request->value,
            'type' => $request->type,
            'ismain' => $request->main ? true : false,
        ]);

        return redirect()->route('profile.contacts.index')->with('success', 'Contact saved');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('profile.contacts.index')->with('success', 'Contact deleted');
    }
}
