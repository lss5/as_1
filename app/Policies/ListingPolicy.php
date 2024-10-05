<?php

namespace App\Policies;

use App\Listing;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListingPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin() || $user->isModerator()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Listing $listing)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Listing $listing)
    {
        return ($user->id == $listing->user->id || $user->isAdmin());
    }

    public function delete(User $user, Listing $listing)
    {
        return ($user->id == $listing->user->id || $user->isAdmin());
    }

    public function restore(User $user, Listing $listing)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Listing $listing)
    {
        return $user->isAdmin();
    }
}
