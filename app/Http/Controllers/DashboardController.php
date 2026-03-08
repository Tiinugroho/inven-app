<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard.
     */
    public function index(Request $request): Response
    {
        // Di sini nantinya Anda bisa memanggil Service untuk mengambil data statistik,
        // misal: $stats = $this->dashboardService->getDailyStats($request->user()->branch_id);

        return Inertia::render('Dashboard', [
            // Anda bisa mem-passing data tambahan ke Vue di sini
            // 'stats' => $stats,
        ]);
    }
}