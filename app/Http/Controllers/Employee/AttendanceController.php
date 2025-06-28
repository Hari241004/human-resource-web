<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Calendar;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $today     = Carbon::today()->toDateString();
        $isHoliday = Calendar::where('date', $today)
                             ->where('type', 'Libur')
                             ->exists();

        $employee = Auth::user()->employee;

        $group = $employee
            ->shiftGroups()
            ->with('shift')
            ->first();
        $shift = $group ? $group->shift : null;

        $attendances = $employee
            ->attendances()
            ->orderByDesc('date')
            ->paginate(10);

        return view('employee.pages.attendance', compact(
            'isHoliday',
            'attendances',
            'shift'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'                 => 'required|date',
            'check_in_time'        => 'required|date_format:H:i',
            'check_out_time'       => 'nullable|date_format:H:i|after:check_in_time',
            'photo'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'check_in_location'    => 'nullable|string|max:255',
            'check_out_location'   => 'nullable|string|max:255',
            'check_in_latitude'    => 'nullable|numeric|between:-90,90',
            'check_in_longitude'   => 'nullable|numeric|between:-180,180',
            'check_out_latitude'   => 'nullable|numeric|between:-90,90',
            'check_out_longitude'  => 'nullable|numeric|between:-180,180',
            'status'               => 'required|in:present,late,absent,excused',
            'notes'                => 'nullable|string',
        ]);

        $date = $request->input('date');

        if (Calendar::where('date', $date)->where('type', 'Libur')->exists()) {
            return back()
                ->with('error',
                    'Gagal absen: ' 
                    . Carbon::parse($date)->isoFormat('D MMMM Y')
                    . ' adalah hari libur.'
                )
                ->withInput();
        }

        $data = $request->only([
            'date',
            'check_in_time',
            'check_out_time',
            'check_in_location',
            'check_out_location',
            'check_in_latitude',
            'check_in_longitude',
            'check_out_latitude',
            'check_out_longitude',
            'status',
            'notes',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('attendances', 'public');
        }

        Auth::user()->employee->attendances()->create($data);

        return redirect()
            ->route('employee.presensi.index')
            ->with('success', 'Presensi berhasil disimpan.');
    }

    /**
     * API: Simpan data check-in dari mobile
     */
    public function apiCheckIn(Request $request)
    {
        $request->validate([
            'datetime'  => 'required|date',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $employee = Auth::user()->employee;

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('absensi', 'public');
        }

        $attendance = $employee->attendances()->create([
            'type' => 'checkin',
            'datetime' => $request->datetime,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo_path' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil',
            'data' => $attendance,
        ]);
    }

    /**
     * API: Simpan data check-out dari mobile
     */
    public function apiCheckOut(Request $request)
    {
        $request->validate([
            'datetime'  => 'required|date',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $employee = Auth::user()->employee;
        $today = Carbon::parse($request->datetime)->toDateString();

        $hasCheckOut = $employee->attendances()
            ->whereDate('datetime', $today)
            ->where('type', 'checkout')
            ->exists();

        if ($hasCheckOut) {
            return response()->json([
                'success' => false,
                'message' => 'Sudah melakukan check-out hari ini.'
            ], 409);
        }

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('absensi', 'public');
        }

        $attendance = $employee->attendances()->create([
            'type' => 'checkout',
            'datetime' => $request->datetime,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo_path' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil',
            'data' => $attendance,
        ]);
    }
}
// End of file: app/Http/Controllers/Employee/AttendanceController.php
//