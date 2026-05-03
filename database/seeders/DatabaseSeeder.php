<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Subdivision;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        // Super Admin
        $adminUser = User::query()->updateOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        $adminUser->syncRoles([RoleName::SuperAdmin->value]);

        // Admin Panel
        $panelAdmin = User::query()->updateOrCreate([
            'email' => 'admin@panel.com',
        ], [
            'name' => 'Panel Admin',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        $panelAdmin->syncRoles([RoleName::PanelAdmin->value]);

        // Federation Admin
        $federationAdmin = User::query()->updateOrCreate([
            'email' => 'admin@federation.com',
        ], [
            'name' => 'Federation Admin',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        $federationAdmin->syncRoles([RoleName::FederationAdmin->value]);

        // Viewer
        $viewer = User::query()->updateOrCreate([
            'email' => 'viewer@federation.com',
        ], [
            'name' => 'Viewer',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        $viewer->syncRoles([RoleName::Viewer->value]);

        if (Subdivision::query()->exists()) {
            $this->call([
                FederationTeamPlayerSeeder::class,
            ]);
        }
    }
}
