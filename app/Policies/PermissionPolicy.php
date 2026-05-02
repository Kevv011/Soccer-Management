<?php

namespace App\Policies;

use App\Enums\PermissionName as PermissionEnum;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionEnum::PermissionsViewAny->value);
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->can(PermissionEnum::PermissionsView->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionEnum::PermissionsCreate->value);
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->can(PermissionEnum::PermissionsUpdate->value);
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->can(PermissionEnum::PermissionsDelete->value);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionEnum::PermissionsDelete->value);
    }
}
