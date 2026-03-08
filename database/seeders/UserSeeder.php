<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $hq = Branch::where('code', 'HQ-001')->first();
        $toko1 = Branch::where('code', 'TKO-001')->first();

        // 1. Buat Akun Super Admin
        $admin = User::create([
            'branch_id' => $hq->id,
            'name'      => 'Muhammad Jati Nugroho',
            'username'  => 'admin', // Login pakai ini
            'email'     => 'admin@pos.local',
            'password'  => Hash::make('password123'),
            'is_active' => true,
        ]);
        
        $admin->profile()->create([
            'nik'          => 'EMP-0001',
            'phone_number' => '081234567890',
            'join_date'    => now()->format('Y-m-d'),
        ]);
        
        $admin->assignRole('Super Admin');

        // 2. Buat Akun Manager Toko
        $manager = User::create([
            'branch_id' => $toko1->id,
            'name'      => 'Budi Santoso',
            'username'  => 'MGR001', // NIK untuk login
            'email'     => 'budi.mgr@pos.local',
            'password'  => Hash::make('password123'),
            'is_active' => true,
        ]);

        $manager->profile()->create([
            'nik'          => 'MGR001',
            'phone_number' => '089876543210',
            'join_date'    => now()->format('Y-m-d'),
        ]);

        $manager->assignRole('Manager');

        // 3. Buat Akun Kasir
        $cashier = User::create([
            'branch_id' => $toko1->id,
            'name'      => 'Siti Aminah',
            'username'  => 'KSR001',
            'email'     => 'siti.kasir@pos.local',
            'password'  => Hash::make('password123'),
            'is_active' => true,
        ]);

        $cashier->profile()->create([
            'nik'          => 'KSR001',
            'phone_number' => '085544332211',
            'join_date'    => now()->format('Y-m-d'),
        ]);

        $cashier->assignRole('Cashier');
    }
}