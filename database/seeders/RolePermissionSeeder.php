<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Permissions
        $permissions = [
            'manage users',
            'manage branches',
            'manage products',
            'manage stocks',
            'create sale',
            'void transaction',
            'create opname',
            'approve opname',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 2. Buat Roles dan Assign Permissions
        
        // Super Admin (Bisa semua hal)
        $superAdmin = Role::create(['name' => 'Super Admin']);
        // Super Admin tidak perlu di-assign satu-satu jika menggunakan gate bypass di AuthServiceProvider, 
        // tapi untuk keamanan kita assign semua
        $superAdmin->givePermissionTo(Permission::all());

        // Manager Toko
        $manager = Role::create(['name' => 'Manager']);
        $manager->givePermissionTo([
            'manage stocks',
            'create sale',
            'void transaction',
            'approve opname',
            'view reports'
        ]);

        // Kasir
        $cashier = Role::create(['name' => 'Cashier']);
        $cashier->givePermissionTo([
            'create sale',
        ]);

        // Staff Gudang / Inventory
        $inventoryStaff = Role::create(['name' => 'Inventory Staff']);
        $inventoryStaff->givePermissionTo([
            'manage products',
            'manage stocks',
            'create opname'
        ]);
    }
}