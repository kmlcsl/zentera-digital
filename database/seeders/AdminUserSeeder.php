<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main admin user
        AdminUser::create([
            'username' => 'admin',
            'email' => 'muhammadkamilcsl19@gmail.com',
            'name' => 'Muhammad Kamil',
            'password' => 'admin190303', // Will be hashed automatically by model
            'role' => 'super_admin',
            'is_active' => true
        ]);

        // Optional: Create backup admin
        AdminUser::create([
            'username' => 'backup_admin',
            'email' => 'backup@digitalproservices.com',
            'name' => 'Backup Admin',
            'password' => 'backup123', // Will be hashed automatically
            'role' => 'admin',
            'is_active' => true
        ]);
    }
}
