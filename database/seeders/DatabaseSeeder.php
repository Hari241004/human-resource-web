<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PayrollSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // (Optional) Buat user test
        \App\Models\User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Panggil seeder lain
        $this->call([
            RoleUserSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            // Seeder-seeder lain yang sudah kamu punya:
            RecruitmentSeeder::class,
            AttendanceSeeder::class,
            AttendanceRequestSeeder::class,
            LeaveRequestSeeder::class,
            CompanyBankAccountsSeeder::class,
            PotonganSeeder::class,
            TunjanganSeeder::class,
            // dst...
        ]);
    }
}
