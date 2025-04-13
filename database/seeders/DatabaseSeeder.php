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
        // Vytvoření uživatele
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Vytvoření rolí
        $admin = Role::create(['name' => 'admin']);
        $viewer = Role::create(['name' => 'viewer']);
        $agent = Role::create(['name' => 'agent']);

        // Vytvoření oprávnění
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'view users']);

        // Přiřazení oprávnění rolím
        $admin->givePermissionTo(['edit users', 'view users']);
        $viewer->givePermissionTo(['view users']);

        // Např. přiřazení role admin prvnímu uživateli
        $user = User::where('email', 'test@example.com')->first();
        $user->assignRole('admin');

        // Spustí RolePermissionSeeder
        $this->call(RolePermissionSeeder::class);

        $this->call(InsuredPersonSeeder::class);

        // Seedujeme pojištění
        $this->call(InsuranceSeeder::class);

        // Volání seederu pro propojení pojištěnců a pojištění
        $this->call(InsuredInsuranceSeeder::class);
    }
}
