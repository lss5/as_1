<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolice
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

    public function view(User $user, Company $company)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Company $company)
    {
        return ($user->id == $company->user->id || $user->isAdmin());
    }

    public function delete(User $user, Company $company)
    {
        return ($user->id == $company->user->id || $user->isAdmin());
    }

    public function restore(User $user, Company $company)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Company $company)
    {
        return $user->isAdmin();
    }
}
