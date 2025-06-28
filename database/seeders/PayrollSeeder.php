<?php

use Illuminate\Database\Seeder;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        $employee = Employee::first();


        if (!$employee) {
            $this->command->warn('No employee found. Seeder skipped.');
            return;
        }

       Payroll::create([
            'employee_id' => $employee->id,
            'start_date'  => Carbon::now()->startOfMonth()->toDateString(),
            'end_date'    => Carbon::now()->endOfMonth()->toDateString(),
            'period'      => Carbon::now()->format('Y-m'),
            'status'      => 'draft',
            'company_bank_name'            => 'Seeder Bank',
            'company_bank_account_number'  => '1234567890',
            'company_bank_account_owner'   => 'Seeder PT',
        ]);

    }
}

