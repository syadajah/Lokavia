<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }

    public function register()
    {
        return view('Auth.register');
    }

 public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }else if ($user->role === 'owner') {
                return redirect()->intended('/owner/dashboard');
            }
            return redirect()->intended('/user/dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

   public function processRegister(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // default
        ]);

        // return redirect()->route('login.form')
        //     ->with('success', 'Registrasi berhasil, silakan login!');

        return redirect()->back()->with('registered', true);
    }

    public function logout(Request $request)
    {
        // Log aktivitas logout sebelum logout
        // ActivityLogHelper::log('logout', 'auth', 'User logout dari sistem', null, null);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
