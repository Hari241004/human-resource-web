<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyBankAccountsSeeder extends Seeder
{
    public function run()
    {
        DB::table('company_bank_accounts')->insert([
            [
                'bank_name' => 'BCA',
                'bank_account_number' => '1234567890',
                'bank_account_owner' => 'PT Contoh Makmur',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_name' => 'Mandiri',
                'bank_account_number' => '9876543210',
                'bank_account_owner' => 'PT Contoh Sejahtera',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

