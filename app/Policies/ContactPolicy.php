<?php

namespace App\Policies;

use App\Contact;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Contact $contact)
    {
        return $user->hasRole('admin');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Contact $contact)
    {
        return ($user->id == $contact->user->id || $user->hasRole('admin'));
    }

    public function delete(User $user, Contact $contact)
    {
        return ($user->id == $contact->user->id || $user->hasRole('admin'));
    }

    public function restore(User $user, Contact $contact)
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Contact $contact)
    {
        return $user->hasRole('admin');
    }
}
