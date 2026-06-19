<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Default Tenant
        $tenant = \App\Models\Tenant::create([
            'id' => 1,
            'nama_sekolah' => 'Sekolah Default',
            'slug' => 'default',
            'email' => 'school@cbt.com',
            'status' => 'premium',
            'expired_at' => '2030-12-31',
            'max_students' => 500,
            'max_teachers' => 50,
            'is_active' => true,
        ]);

        // 2. Seed Super Admin
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
            'tenant_id' => null,
        ]);

        // 3. Seed Tenant Admin (Default School Admin)
        \App\Models\User::create([
            'name' => 'Admin Sekolah Default',
            'email' => 'school@cbt.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'tenant_id' => $tenant->id,
        ]);
    }
}
