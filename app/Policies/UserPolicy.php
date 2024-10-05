<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin() || $user->isModerator()) {
            return true;
        }
    }

    public function viewAny(User $current_user)
    {
        return true;
    }

    public function view(User $current_user, User $user)
    {
        return $current_user->id === $user->id || $current_user->isAdmin();
    }

    public function create(User $current_user)
    {
        return $current_user->isAdmin();
    }

    public function update(User $current_user, User $user)
    {
        return $current_user->id === $user->id || $current_user->isAdmin();
    }

    public function delete(User $current_user, User $user)
    {
        return $current_user->isAdmin();
    }

    public function restore(User $current_user, User $user)
    {
        return $current_user->isAdmin();
    }

    public function forceDelete(User $current_user, User $user)
    {
        return $current_user->isAdmin();
    }
}
