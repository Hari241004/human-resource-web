<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        // Range tanggal: 1 bulan kemarin sampai hari ini
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        foreach ($employees as $employee) {
            $date = $startDate->copy();

            while ($date->lte($endDate)) {
                // Random status
                $statusOptions = ['present', 'late', 'absent', 'excused'];
                $status = $statusOptions[array_rand($statusOptions)];

                // Only if present or late → generate check-in/out time
                $checkInTime = in_array($status, ['present', 'late'])
                    ? Carbon::createFromTime(rand(8,9), rand(0,59))
                    : null;

                $checkOutTime = in_array($status, ['present', 'late'])
                    ? Carbon::createFromTime(rand(16,18), rand(0,59))
                    : null;

                Attendance::create([
                    'employee_id'        => $employee->id,
                    'date'               => $date->format('Y-m-d'),
                    'check_in_time'      => $checkInTime ? $checkInTime->format('H:i:s') : null,
                    'check_out_time'     => $checkOutTime ? $checkOutTime->format('H:i:s') : null,
                    'photo_path'         => '/dummy/attendance_' . Str::random(10) . '.jpg',
                    'check_in_location'  => 'Office',
                    'status'             => $status,
                    'notes'              => $status == 'absent' ? 'Tidak hadir' : null,
                ]);

                // Next day
                $date->addDay();
            }
        }
    }
}
