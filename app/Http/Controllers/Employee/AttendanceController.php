<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Tampilkan form Presensi (check-in / check-out)
     * View sekarang di resources/views/employee/pages/attendance.blade.php
     */
    public function create()
    {
        return view('employee.pages.attendance');
    }

    /**
     * Simpan presensi.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date'              => 'required|date',
            'check_in_time'     => 'required|date_format:H:i',
            'check_out_time'    => 'nullable|date_format:H:i|after:check_in_time',
            'photo'             => 'nullable|image|max:2048',
            'check_in_location' => 'nullable|string|max:255',
            'status'            => 'required|in:present,late,absent,excused',
            'notes'             => 'nullable|string',
        ]);

        $data['employee_id'] = Auth::id();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')
                                     ->store('attendances','public');
        }

        Attendance::create($data);

        return redirect()
               ->route('employee.presensi.request')  // tetap ke form yang sama
               ->with('success', 'Presensi berhasil disimpan.');
    }
}
