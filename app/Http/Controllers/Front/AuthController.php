<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use lang;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;

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
            'g-recaptcha-response' => 'required|recaptcha'
        ], [], [
            'email' => lang::translate('dashboard.form-login.label-email'),
            'password' => lang::translate('dashboard.form-login.label-password'),
            'g-recaptcha-response' => lang::translate('global.recaptcha'),
        ]);

        $remember = false;

        // Only allow active accounts
        $attemptCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_active' => 1,
        ];


        $account = Account::where('email', $credentials['email'])->first();
        if ($account != null) {
            if (Hash::check($credentials['password'], $account->password)) {
                if ($account->is_active) {
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
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => lang::translate('dashboard.form-login.inactive-user'),
                        'errors' => [
                            'email' => [lang::translate('dashboard.form-login.inactive-user')],
                        ],
                    ], 422);
                }
            }
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


