<?php

namespace App\Policies;

use App\Enums\PermissionName;
use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionName::TeamsViewAny->value);
    }

    public function view(User $user, Team $team): bool
    {
        return $user->can(PermissionName::TeamsView->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionName::TeamsCreate->value);
    }

    public function update(User $user, Team $team): bool
    {
        return $user->can(PermissionName::TeamsUpdate->value);
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->can(PermissionName::TeamsDelete->value);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionName::TeamsDelete->value);
    }
}
