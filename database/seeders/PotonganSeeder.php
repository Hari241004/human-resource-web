<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Potongan;

class PotonganSeeder extends Seeder
{
    public function run(): void
    {
        $deductions = [
            [ 'name' => 'BPJS Kesehatan (1%)',              'amount' => 0.01   ],
            [ 'name' => 'BPJS Ketenagakerjaan - JHT (2%)',  'amount' => 0.02   ],
            [ 'name' => 'BPJS Ketenagakerjaan - JP (1%)',   'amount' => 0.01   ],
            [ 'name' => 'BPJS Ketenagakerjaan - JKK (0.24%)','amount' => 0.0024 ],
            [ 'name' => 'BPJS Ketenagakerjaan - JKM (0.30%)','amount' => 0.003  ],
            [ 'name' => 'PPh 21 (Jika Berlaku)',            'amount' => 0.05   ],
        ];

        foreach ($deductions as $data) {
            Potongan::updateOrCreate(
                ['name' => $data['name']],
                ['amount' => $data['amount']]
            );
        }
    }
}
