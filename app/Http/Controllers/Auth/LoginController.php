<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $user = Auth::user();
            
            // Update last_login ke waktu sekarang
            $user->update(['last_login' => Carbon::now()]);

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard.admin');
                case 'umkm':
                    return redirect()->route('dashboard.umkm.index');
                case 'konsultan':
                    return redirect()->route('dashboard.konsultan.index');
                case 'kepala_uptd':
                    return redirect()->route('dashboard.kepalauptd.index');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Akun tidak memiliki role yang valid.');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout');
    }

}
