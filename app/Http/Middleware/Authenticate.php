<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use lang;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {

            if (auth()->guard($guard)->check()) {

                $user = auth()->guard($guard)->user();

                // Cek apakah status user aktif
                if ($guard == 'account' && !$user->is_active) {
                    auth($guard)->logout();

                    // Redirect ke login atau kemanapun
                    abort(redirect(lang::url('/')));
                }

                return;
            }
        }

        $this->unauthenticated($request, $guards);
    }
    
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->is('regulasi*') || $request->is('dashboard*') || $request->is('admin*')) {
                return url(config('cadmin.cadmin.admin-url', 'admin-panel') . '/guest/login');
            }
            return route('home');
        }

        return null;
    }
}


