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

    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

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
        if (in_array($product->status, Product::$status_for_edit)) {
            return $user->id == $product->user_id;
        }
    }

    public function delete(User $user, Product $product)
    {
        return $user->id == $product->user_id;
    }
    
    public function restore(User $user, Product $product)
    {
        // return false;
        return $user->hasRole('moder');
    }

    public function forceDelete(User $user, Product $product)
    {
        return false;
        // return $user->hasRole('admin');
    }
}
