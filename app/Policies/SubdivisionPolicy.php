<?php

namespace App\Policies;

use App\Enums\PermissionName;
use App\Models\Subdivision;
use App\Models\User;

class SubdivisionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionName::SubdivisionsViewAny->value);
    }

    public function view(User $user, Subdivision $subdivision): bool
    {
        return $user->can(PermissionName::SubdivisionsView->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionName::SubdivisionsCreate->value);
    }

    public function update(User $user, Subdivision $subdivision): bool
    {
        return $user->can(PermissionName::SubdivisionsUpdate->value);
    }

    public function delete(User $user, Subdivision $subdivision): bool
    {
        return $user->can(PermissionName::SubdivisionsDelete->value);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionName::SubdivisionsDelete->value);
    }
}
