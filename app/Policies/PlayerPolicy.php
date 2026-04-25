<?php

namespace App\Policies;

use App\Enums\PermissionName;
use App\Models\Player;
use App\Models\User;

class PlayerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionName::PlayersViewAny->value);
    }

    public function view(User $user, Player $player): bool
    {
        return $user->can(PermissionName::PlayersView->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionName::PlayersCreate->value);
    }

    public function update(User $user, Player $player): bool
    {
        return $user->can(PermissionName::PlayersUpdate->value);
    }

    public function delete(User $user, Player $player): bool
    {
        return $user->can(PermissionName::PlayersDelete->value);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionName::PlayersDelete->value);
    }
}
