<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Exception;

class UserService
{
    /**
     * Membuat User, Profil, dan assign Role secara bersamaan
     */
    public function createEmployee(array $userData, array $profileData, string $roleName): User
    {
        // Mulai Database Transaction
        DB::beginTransaction();

        try {
            // 1. Validasi Role exist atau tidak (opsional tapi disarankan)
            $role = Role::findByName($roleName);

            // 2. Buat Data Auth User
            $user = User::create([
                'name'      => $userData['name'],
                'username'  => $userData['username'],
                'email'     => $userData['email'],
                'password'  => Hash::make($userData['password']),
                'branch_id' => $userData['branch_id'],
                'is_active' => $userData['is_active'] ?? true,
            ]);

            // 3. Buat Detail Profil HRD
            $user->profile()->create([
                'nik'                     => $profileData['nik'],
                'phone_number'            => $profileData['phone_number'] ?? null,
                'address'                 => $profileData['address'] ?? null,
                'identity_number'         => $profileData['identity_number'] ?? null,
                'emergency_contact_name'  => $profileData['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $profileData['emergency_contact_phone'] ?? null,
                'join_date'               => $profileData['join_date'] ?? now()->toDateString(),
            ]);

            // 4. Assign Role Spatie ke User
            $user->assignRole($role);

            // Simpan semua perubahan ke database secara permanen
            DB::commit();

            // Kembalikan objek user beserta relasinya untuk response API
            return $user->load(['profile', 'branch', 'roles']);

        } catch (Exception $e) {
            // Jika ada yang gagal (misal NIK duplikat), batalkan semua insert data
            DB::rollBack();
            
            // Lemparkan error ke Controller agar bisa ditangani (misal diubah jadi Response 500)
            throw new Exception("Gagal mendaftarkan karyawan: " . $e->getMessage());
        }
    }
}