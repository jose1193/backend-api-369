<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            Permission::create(['name' => 'manage manager', 'guard_name' => 'sanctum']),
            Permission::create(['name' => 'manage customer', 'guard_name' => 'sanctum']),
            Permission::create(['name' => 'manage others', 'guard_name' => 'sanctum']),
        ];

        // MANAGER USER
        $managerRole = Role::create(['name' => 'Manager', 'guard_name' => 'sanctum']);
        $managerRole->syncPermissions($permissions);

        $managerUser = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@manager.com',
            'phone' => '00000',
            'password' => bcrypt('password')
        ]);
        $managerUser->assignRole($managerRole);
        // END MANAGER USER

        // MANAGER CUSTOMER
        $customerRole = Role::create(['name' => 'Customer', 'guard_name' => 'sanctum']);
        $customerRole->syncPermissions([$permissions[1]]);

        $customerUser = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@customer.com',
            'phone' => '00000',
            'password' => bcrypt('password')
        ]);
        $customerUser->assignRole($customerRole);
        // END MANAGER CUSTOMER

        // OTHERS ROLES
        $othersRole = Role::create(['name' => 'Others', 'guard_name' => 'sanctum']);
        $othersRole->syncPermissions([$permissions[2]]);
        // END OTHERS ROLES
    }
}