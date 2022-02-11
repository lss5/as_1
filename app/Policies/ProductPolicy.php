<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

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
        if (empty($user->ga_verify)) {
            return Response::deny('You need to enable two-factor authentication to create a listing. This can be done on the Profile page.');
        }
        if ($user->products()->count() >= config('product.limit_create_listing')) {
            return Response::deny('Sorry, but we have a limit on the creation of listings.');
        }
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
