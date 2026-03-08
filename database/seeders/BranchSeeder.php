<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'code' => 'HQ-001',
                'name' => 'Kantor Pusat Pekanbaru',
                'address' => 'Jl. Sudirman, Pekanbaru',
                'phone_number' => '0761-123456',
                'is_active' => true,
            ],
            [
                'code' => 'TKO-001',
                'name' => 'Cabang HR Soebrantas',
                'address' => 'Jl. HR Soebrantas, Panam, Pekanbaru',
                'phone_number' => '081122334455',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}