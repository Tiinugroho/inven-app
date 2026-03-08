<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class RoleService
{
    /**
     * Mengambil semua role beserta permission yang dimilikinya.
     */
    public function getAllRolesWithPermissions(): Collection
    {
        return Role::with('permissions')->get();
    }

    /**
     * Mengambil semua master data permission yang tersedia di sistem.
     */
    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    /**
     * Menyimpan role baru beserta hak aksesnya.
     */
    public function createRole(array $data): Role
    {
        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $data['name']]);
            
            if (!empty($data['permissions'])) {
                $role->syncPermissions($data['permissions']);
            }

            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Gagal membuat Role: " . $e->getMessage());
        }
    }

    /**
     * Mengambil satu role berdasarkan ID beserta permission-nya.
     */
    public function getRoleById(int $id): Role
    {
        return Role::with('permissions')->findOrFail($id);
    }

    /**
     * Memperbarui data role dan sinkronisasi permission.
     */
    public function updateRole(int $id, array $data): Role
    {
        DB::beginTransaction();
        try {
            $role = Role::findOrFail($id);
            $role->update(['name' => $data['name']]);
            
            // syncPermissions otomatis menghapus yang tidak dicentang dan menambah yang baru dicentang
            $role->syncPermissions($data['permissions'] ?? []);

            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Gagal mengupdate Role: " . $e->getMessage());
        }
    }

    /**
     * Menghapus role dari sistem.
     */
    public function deleteRole(int $id): void
    {
        $role = Role::findOrFail($id);
        
        // Proteksi keamanan tingkat enterprise: Jangan biarkan Super Admin terhapus
        if ($role->name === 'Super Admin') {
            throw new Exception("Keamanan Sistem: Role Super Admin tidak boleh dihapus.");
        }
        
        $role->delete();
    }
}