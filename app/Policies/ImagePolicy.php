<?php

namespace App\Policies;

use App\Image;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Image $image)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Image $image)
    {
        return ($user->id == $image->product->user_id || $user->hasRole('admin'));
    }

    public function delete(User $user, Image $image)
    {
        return ($user->id == $image->product->user_id || $user->hasRole('admin'));
    }

    public function restore(User $user, Image $image)
    {
        return ($user->id == $image->product->user_id || $user->hasRole('admin'));
    }

    public function forceDelete(User $user, Image $image)
    {
        return $user->hasRole('admin');
    }
}
