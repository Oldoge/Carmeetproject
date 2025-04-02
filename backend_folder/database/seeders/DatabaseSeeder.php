<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',


            $roleAdmin = Role::create(['name' => 'admin']),
            $roleUser = Role::create(['name' => 'user']),
    
            Permission::create(['name' => 'manage users'])->assignRole($roleAdmin),
            Permission::create(['name' => 'edit profile'])->assignRole($roleUser),
        ]);
    }
}
