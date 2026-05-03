<?php

namespace App\Policies;

use App\Enums\PermissionName;
use App\Models\ReportGeneration;
use App\Models\User;

class ReportGenerationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionName::ReportGenerationsViewAny->value);
    }

    public function view(User $user, ReportGeneration $reportGeneration): bool
    {
        return $user->can(PermissionName::ReportGenerationsView->value)
            && ($reportGeneration->user_id === $user->id);
    }
}
