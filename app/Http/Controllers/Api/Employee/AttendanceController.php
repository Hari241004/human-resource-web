<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Calendar;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user();
        $employee = $user->employee;

        if (! $employee) {
            return response()->json(['error'=>'Not an employee'], 403);
        }

        $today     = Carbon::today()->toDateString();
        $isHoliday = Calendar::where('date', $today)
                             ->where('type','Libur')
                             ->exists();

        $group = $employee->shiftGroups()->with('shift')->first();
        $shift = $group ? $group->shift : null;

        $attendances = $employee
            ->attendances()
            ->orderByDesc('date')
            ->paginate(10);

        return response()->json([
            'isHoliday'   => $isHoliday,
            'shift'       => $shift,
            'attendances' => $attendances,
        ]);
    }

    public function store(Request $request)
    {
        $employee = Auth::user()->employee;
        $today    = Carbon::today()->toDateString();

        if (! $employee) {
            return response()->json([
                'error' => 'User tidak memiliki data karyawan.'
            ], 403);
        }

        if (Calendar::where('date', $today)->where('type','Libur')->exists()) {
            return response()->json([
                'error' => 'Tidak bisa absen di hari libur (' . $today . ')'
            ], 422);
        }

        $request->validate([
            'check_in_location'   => 'nullable|string|max:255',
            'check_out_location'  => 'nullable|string|max:255',
            'check_in_latitude'   => 'nullable|numeric|between:-90,90',
            'check_in_longitude'  => 'nullable|numeric|between:-180,180',
            'check_out_latitude'  => 'nullable|numeric|between:-90,90',
            'check_out_longitude' => 'nullable|numeric|between:-180,180',
            'photo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $attendance = Attendance::firstOrNew([
            'employee_id' => $employee->id,
            'date'        => $today
        ]);

        // ✅ Proses Check-in
        if (!$attendance->check_in_time) {
            $attendance->check_in_time       = now()->toTimeString();
            $attendance->check_in_location   = $request->check_in_location;
            $attendance->check_in_latitude   = $request->check_in_latitude;
            $attendance->check_in_longitude  = $request->check_in_longitude;
            $attendance->status              = now()->hour > 8 ? 'late' : 'present';

            if ($request->hasFile('photo')) {
                $attendance->photo_path = $request->file('photo')->store('attendances', 'public');
            }

            $attendance->save();

            return response()->json([
                'message' => 'Check-in berhasil',
                'data'    => [
                    'check_in_time'     => $attendance->check_in_time,
                    'check_in_location' => $attendance->check_in_location,
                    'latitude'          => $attendance->check_in_latitude,
                    'longitude'         => $attendance->check_in_longitude,
                    'status'            => $attendance->status,
                    'photo_url'         => $attendance->photo_path ? asset('storage/' . $attendance->photo_path) : null,
                ]
            ], 201);
        }

        // ✅ Proses Check-out
        if (!$attendance->check_out_time) {
            $attendance->check_out_time       = now()->toTimeString();
            $attendance->check_out_location   = $request->check_out_location;
            $attendance->check_out_latitude   = $request->check_out_latitude;
            $attendance->check_out_longitude  = $request->check_out_longitude;

            $attendance->save();

            return response()->json([
                'message' => 'Check-out berhasil',
                'data'    => [
                    'check_out_time'     => $attendance->check_out_time,
                    'check_out_location' => $attendance->check_out_location,
                    'latitude'           => $attendance->check_out_latitude,
                    'longitude'          => $attendance->check_out_longitude,
                ]
            ], 200);
        }

        return response()->json(['message' => 'Sudah check-in dan check-out hari ini.'], 409);
    }
}
// End of file: app/Http/Controllers/Api/Employee/AttendanceController.php      