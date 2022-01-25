<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRoles(['admin', 'moder']);
    }

    public function view(User $user, Product $product)
    {
        return $user->hasAnyRoles(['admin', 'moder']);
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
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
