<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{
    /**
     * Tampilkan daftar posisi (dapat di-filter berdasarkan department_id).
     */
    public function index(Request $request)
    {
        $query = Position::with('department')->withCount('employees');

        if ($deptId = $request->query('department_id')) {
            $query->where('department_id', $deptId);
        }

        $positions   = $query->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.pages.position-index', compact('positions', 'departments'));
    }

    /**
     * Tampilkan detail sebuah posisi dan paginate daftar pegawai, plus search.
     */
    public function show(Request $request, Position $position)
    {
        $search = $request->input('search');

        $query = $position
            ->employees()
            ->with('recruitment', 'department')
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('recruitment', function($q2) use ($search) {
                      $q2->where('phone', 'like', "%{$search}%");
                  });
            });

        $employees = $query->paginate(10)->appends(compact('search'));

        return view('admin.pages.position-show', compact('position', 'employees', 'search'));
    }

    /**
     * Tampilkan form edit posisi.
     */
    public function edit(Position $position)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.pages.position-edit', compact('position', 'departments'));
    }

    /**
     * Simpan posisi baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name'          => [
                'required','string','max:255',
                Rule::unique('positions','name')
                    ->where('department_id', $request->department_id),
            ],
        ]);

        Position::create($data);

        return back()->with('success', 'Position berhasil ditambahkan.');
    }

    /**
     * Update posisi yang ada.
     */
    public function update(Request $request, Position $position)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name'          => [
                'required','string','max:255',
                Rule::unique('positions','name')
                    ->where('department_id', $request->department_id)
                    ->ignore($position->id),
            ],
        ]);

        $position->update($data);

        return redirect()
            ->route('admin.positions.index', ['department_id' => $data['department_id']])
            ->with('success', 'Position berhasil diperbarui.');
    }

    /**
     * Hapus sebuah posisi.
     */
    public function destroy(Position $position)
    {
        if ($position->employees()->exists()) {
            return back()->withErrors([
                'error' => 'Tidak bisa menghapus: masih ada pegawai di posisi ini.'
            ]);
        }

        $deptId = $position->department_id;
        $position->delete();

        return redirect()
            ->route('admin.positions.index', ['department_id' => $deptId])
            ->with('success', 'Position berhasil dihapus.');
    }
}
