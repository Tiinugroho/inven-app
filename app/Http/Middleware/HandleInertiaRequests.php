<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return array_merge(parent::share($request), [
            // Kirim data user yang sedang login beserta role & permission-nya
            'auth' => [
                'user' => $user,
                // Mengambil nama role (contoh: ['Cashier'])
                'roles' => $user ? $user->getRoleNames() : [],
                // Mengambil nama permission (contoh: ['create sale', 'view products'])
                'permissions' => $user ? $user->getAllPermissions()->pluck('name') : [],
                // Kirim juga data toko tempat user ini bekerja
                'branch' => $user ? $user->branch : null,
            ],
        ]);
    }
}
