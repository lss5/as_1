<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isModerator();
    }

    public function view(User $user, Thread $thread)
    {
        if ($user->isAdmin() || $user->isModerator()) return true;

        $participants = $thread->participantsUserIds();
        foreach ($participants as $participant) {
            if ($participant == $user->id) {
                return true;
            }
        }

        return false;
    }

    public function create(User $user)
    {
        return $user->isAdmin() || $user->isModerator() ? true : false;
    }

    public function update(User $user, Thread $thread)
    {
        if ($user->isAdmin() || $user->isModerator()) return true;

        $participants = $thread->participantsUserIds();
        foreach ($participants as $participant) {
            if ($participant == $user->id) {
                return true;
            }
        }

        return false;
    }

    public function delete(User $user, Thread $thread)
    {
        return $user->isAdmin() || $user->isModerator() ? true : false;
    }

    public function restore(User $user, Thread $thread)
    {
        return $user->isAdmin() || $user->isModerator() ? true : false;
    }

    public function forceDelete(User $user, Thread $thread)
    {
        return false;
    }
}
