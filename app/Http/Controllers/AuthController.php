<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /* FORM LOGIN */
    public function loginForm()
    {
        return view('auth.login');
    }

    /* PROSES LOGIN */
   public function login(Request $request)
        {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            if (Auth::attempt([
                'username' => $request->username,
                'password' => $request->password,
                'status' => 'Aktif'
            ])) {

                $request->session()->regenerate();

                Auth::user()->update([
                    'last_active' => now()
                ]);

                return redirect('/dashboard');
            }

            return back()->with('error', 'Username atau password salah');
        }
    /* LOGOUT */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->update([
                'last_active' => now()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

 // LUPA PASSWORD
    public function forgotPassword()
{
    return view('auth.forgot-password');
}
}