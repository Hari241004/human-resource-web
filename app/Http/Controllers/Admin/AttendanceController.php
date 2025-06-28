<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Calendar;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with('employee')
            ->when($request->date,   fn($q) => $q->whereDate('date', $request->date))
            ->when($request->status, fn($q) => $q->where('status',    $request->status))
            ->latest('date')
            ->paginate(15);

        return view('admin.pages.attendance', compact('attendances'));
    }

    public function show(Attendance $attendance)
    {
        return view('admin.pages.attendance-show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        // Jika hari absensi itu bertipe 'Libur', tolak edit
        if (Calendar::where('date', $attendance->date)
                    ->where('type', 'Libur')
                    ->exists()
        ) {
            return redirect()
                ->route('admin.attendance.index')
                ->with('error', 'Tidak bisa mengubah: ' . Carbon::parse($attendance->date)->isoFormat('D MMMM Y') . ' adalah hari libur.');
        }

        return view('admin.pages.attendance-edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        // Pastikan kembali bukan hari libur
        if (Calendar::where('date', $attendance->date)
                    ->where('type', 'Libur')
                    ->exists()
        ) {
            return back()
                ->with('error', 'Tidak bisa mengubah data pada hari libur.');
        }

        $data = $request->validate([
            'check_in_time'     => 'nullable|date_format:H:i',
            'check_out_time'    => 'nullable|date_format:H:i|after:check_in_time',
            'status'            => 'required|in:present,late,absent,excused',
            'notes'             => 'nullable|string',
            'check_in_location' => 'nullable|string|max:255',
        ]);

        $attendance->update($data);

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
}
