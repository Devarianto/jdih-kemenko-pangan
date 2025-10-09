<?php

namespace App\Http\Middleware;

use Closure;

class Frontend
{
    public function handle($request, Closure $next)
    {
        if (in_array(config('app.env'),['fe']) && request()->segment(1) != 'front') {
            return \Redirect::to('front');
        }
        view()->share('frontend',true);
        return $next($request);
    }
}
