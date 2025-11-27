<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use lang;

class AuthController extends Controller
{
    /**
     * Handle frontend login using accounts table.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
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
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('dashboard'),
                ]);
            }
            return redirect()->route('dashboard');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => lang::translate('dashboard.form-login.unknown-user'),
                'errors' => [
                    'email' => [lang::translate('dashboard.form-login.unknown-user')],
                ],
            ], 422);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => lang::translate('dashboard.form-login.unknown-user'),
            ]);
    }

    /**
     * Logout current authenticated account.
     */
    public function logout(Request $request)
    {
        Auth::guard('account')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}


