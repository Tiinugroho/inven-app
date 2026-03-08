<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class, // Spatie harus paling awal
            BranchSeeder::class,         // Cabang harus ada sebelum User
            UserSeeder::class,           // User dibuat terakhir karena butuh Role & Branch
        ]);
    }
}