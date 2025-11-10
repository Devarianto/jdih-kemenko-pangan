<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle frontend login using accounts table.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = false;

        // Only allow active accounts
        $attemptCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_active' => 1,
        ];

        if (Auth::guard('account')->attempt($attemptCredentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password tidak sesuai, atau akun belum aktif.',
            ]);
    }

    /**
     * Logout current authenticated account.
     */
    public function logout(Request $request)
    {
        Auth::guard('account')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}


