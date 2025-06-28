<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tunjangan;

class TunjanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allowances = [
            [ 'name' => 'Tunjangan Jabatan',      'amount' => 1_000_000 ],
            [ 'name' => 'Tunjangan Makan',        'amount' =>   500_000 ],
            [ 'name' => 'Tunjangan Transport',    'amount' =>   300_000 ],
            [ 'name' => 'Tunjangan Komunikasi',   'amount' =>   150_000 ],
            [ 'name' => 'Tunjangan Kesehatan',    'amount' =>   200_000 ],
        ];

        foreach ($allowances as $data) {
            Tunjangan::updateOrCreate(
                ['name' => $data['name']],
                ['amount' => $data['amount']]
            );
        }
    }
}
