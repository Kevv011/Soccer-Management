<?php

namespace App\Policies;

use App\Enums\PermissionName;
use App\Models\Federation;
use App\Models\User;

class FederationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionName::FederationsViewAny->value);
    }

    public function view(User $user, Federation $federation): bool
    {
        return $user->can(PermissionName::FederationsView->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionName::FederationsCreate->value);
    }

    public function update(User $user, Federation $federation): bool
    {
        return $user->can(PermissionName::FederationsUpdate->value);
    }

    public function delete(User $user, Federation $federation): bool
    {
        return $user->can(PermissionName::FederationsDelete->value);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionName::FederationsDelete->value);
    }
}
