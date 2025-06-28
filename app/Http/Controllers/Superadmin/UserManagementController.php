<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('superadmin.pages.user-management.index', compact('users'));
    }

    public function create()
    {
        $roles = User::getRoles(); // [ 'user'=>'Employee', ... ]
        return view('superadmin.pages.user-management.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:'.implode(',', array_keys(User::getRoles())),
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        return redirect()->route('superadmin.users.index')
                         ->with('success','Pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = User::getRoles();
        return view('superadmin.pages.user-management.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role'  => 'required|in:'.implode(',', array_keys(User::getRoles())),
        ]);

        $user->update($data);
        return redirect()->route('superadmin.users.index')
                         ->with('success','Pengguna berhasil diubah.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','Pengguna berhasil dihapus.');
    }
}
