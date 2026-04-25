<?php

namespace App\Policies;

use App\Enums\PermissionName;
use App\Models\Country;
use App\Models\User;

class CountryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionName::CountriesViewAny->value);
    }

    public function view(User $user, Country $country): bool
    {
        return $user->can(PermissionName::CountriesView->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionName::CountriesCreate->value);
    }

    public function update(User $user, Country $country): bool
    {
        return $user->can(PermissionName::CountriesUpdate->value);
    }

    public function delete(User $user, Country $country): bool
    {
        return $user->can(PermissionName::CountriesDelete->value);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionName::CountriesDelete->value);
    }
}
