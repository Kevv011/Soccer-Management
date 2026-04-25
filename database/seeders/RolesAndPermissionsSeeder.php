<?php

namespace Database\Seeders;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (PermissionName::values() as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        $superAdminRole = Role::findOrCreate(RoleName::SuperAdmin->value, 'web');
        $panelAdminRole = Role::findOrCreate(RoleName::PanelAdmin->value, 'web');
        $federationAdminRole = Role::findOrCreate(RoleName::FederationAdmin->value, 'web');
        $viewerRole = Role::findOrCreate(RoleName::Viewer->value, 'web');

        $allPermissions = Permission::query()->pluck('name')->all();

        $superAdminRole->syncPermissions($allPermissions);
        $panelAdminRole->syncPermissions($allPermissions);
        $federationAdminRole->syncPermissions([
            PermissionName::PanelAccess->value,
            PermissionName::FederationsViewAny->value,
            PermissionName::FederationsView->value,
            PermissionName::FederationsCreate->value,
            PermissionName::FederationsUpdate->value,
            PermissionName::TeamsViewAny->value,
            PermissionName::TeamsView->value,
            PermissionName::TeamsCreate->value,
            PermissionName::TeamsUpdate->value,
            PermissionName::PlayersViewAny->value,
            PermissionName::PlayersView->value,
            PermissionName::PlayersCreate->value,
            PermissionName::PlayersUpdate->value,
            PermissionName::MediaManage->value,
        ]);
        $viewerRole->syncPermissions([
            PermissionName::PanelAccess->value,
            PermissionName::CountriesViewAny->value,
            PermissionName::CountriesView->value,
            PermissionName::SubdivisionsViewAny->value,
            PermissionName::SubdivisionsView->value,
            PermissionName::FederationsViewAny->value,
            PermissionName::FederationsView->value,
            PermissionName::TeamsViewAny->value,
            PermissionName::TeamsView->value,
            PermissionName::PlayersViewAny->value,
            PermissionName::PlayersView->value,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
