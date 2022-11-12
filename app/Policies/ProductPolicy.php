<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\AuthorizationException;


class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Product $product)
    {
        return true;
        // return optional($user)->id === $post->user_id;
        // return $user->hasAnyRoles(['admin', 'moder']);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Product $product)
    {
        return ($user->id == $product->user_id || $user->hasRole('admin'));
    }

    public function delete(User $user, Product $product)
    {
        return ($user->id == $product->user_id || $user->hasRole('admin'));
    }

    public function restore(User $user, Product $product)
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Product $product)
    {
        return $user->hasRole('admin');
    }
}
