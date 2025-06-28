<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
      $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            if (auth()->user()->role == 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            } elseif (auth()->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role == 'user') {
                return redirect()->route('employee.dashboard');
            }
              
            }
            return redirect()->back()->withErrors(['loginError' => 'Email atau password salah']);
            
        }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    
}
