<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Exception;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService)
    {
        // Pastikan hanya yang punya hak akses yang bisa masuk ke halaman ini
        // $this->middleware('permission:manage users'); 
    }

    /**
     * Menampilkan daftar role.
     */
    public function index(): Response
    {
        $roles = $this->roleService->getAllRolesWithPermissions();
        $permissions = $this->roleService->getAllPermissions();

        return Inertia::render('Roles/Index', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Menampilkan halaman form tambah role.
     */
    public function create(): Response
    {
        // Ambil semua permission murni dari database
        $permissions = $this->roleService->getAllPermissions();

        return Inertia::render('Roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Menyimpan data role baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $this->roleService->createRole($validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman edit form.
     */
    public function edit($id): Response
    {
        $role = $this->roleService->getRoleById($id);
        $permissions = $this->roleService->getAllPermissions();

        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Memproses update data role.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            // Pengecualian unique untuk ID yang sedang di-edit agar tidak error duplicate
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $this->roleService->updateRole($id, $validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui!');
    }

    /**
     * Memproses penghapusan data role.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->roleService->deleteRole($id);
            return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus!');
        } catch (Exception $e) {
            // Mengembalikan pesan error jika gagal (misal mencoba menghapus Super Admin)
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}