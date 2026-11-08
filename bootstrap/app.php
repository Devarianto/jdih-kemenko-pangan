<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            if (!in_array(config('app.env'),['production','live'])) {
                Route::prefix('front')
                    ->middleware('web')
                    ->group(base_path('routes/front.php'));
            };
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\HSTS::class);
        $middleware->web(append: [
            \App\Http\Middleware\Frontend::class
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'root' => \Cactuar\Admin\Http\Middleware\Root::class,
            'admin' => \Cactuar\Admin\Http\Middleware\Admin::class,
            'minify' => \Cactuar\Admin\Http\Middleware\Minify::class,
            'front' => \App\Http\Middleware\Front::class,
            'visitor-count' => \App\Http\Middleware\VisitorCount::class,
            'csp' => \App\Http\Middleware\ContentSecurityPolicy::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
