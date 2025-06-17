<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\InsuredPerson;
use App\Models\Insurance;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Vytvoření uživatelů
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('hesloAdmin123'),
        ]);

        $agent1User = User::factory()->create([
            'name' => 'Agent One',
            'email' => 'agent1@example.com',
            'password' => bcrypt('hesloAgent1'),
        ]);

        $agent2User = User::factory()->create([
            'name' => 'Agent Two',
            'email' => 'agent2@example.com',
            'password' => bcrypt('hesloAgent2'),
        ]);

        // Vytvoření rolí
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleViewer = Role::create(['name' => 'viewer']);
        $roleAgent = Role::create(['name' => 'agent']);

        // Vytvoření oprávnění
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'view users']);

        // Přiřazení oprávnění rolím
        $roleAdmin->givePermissionTo(['edit users', 'view users']);
        $roleViewer->givePermissionTo(['view users']);

        // Přiřazení rolí uživatelům
        $adminUser->assignRole('admin');
        $agent1User->assignRole('agent');
        $agent2User->assignRole('agent');

        // Volání dalších seedů
        $this->call(RolePermissionSeeder::class);
        $this->call(InsuredPersonSeeder::class);
        $this->call(InsuranceSeeder::class);
        $this->call(InsuredInsuranceSeeder::class);
    }
}
