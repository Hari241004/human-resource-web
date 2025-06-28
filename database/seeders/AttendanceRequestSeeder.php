<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AttendanceRequestSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        // Range tanggal: 1 bulan kemarin sampai hari ini
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $typeOptions = ['sakit', 'izin', 'dinas', 'cuti'];
        $statusOptions = ['pending', 'approved', 'rejected'];

        foreach ($employees as $employee) {
            // Untuk contoh → generate 5-10 request per employee
            $requestCount = rand(5, 10);

            for ($i = 0; $i < $requestCount; $i++) {
                $date = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d');

                $status = $statusOptions[array_rand($statusOptions)];

                $reviewed_by = $status == 'pending' ? null : rand(1, 3); // contoh admin user_id 1-3

                DB::table('attendance_requests')->insert([
                    'employee_id'      => $employee->id,
                    'date'             => $date,
                    'type'             => $typeOptions[array_rand($typeOptions)],
                    'submission_time'  => now(),
                    'reason'           => 'Reason for request ' . Str::random(10),
                    'status'           => $status,
                    'reviewed_by'      => $reviewed_by,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
