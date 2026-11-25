<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' https://www.google.com https://www.gstatic.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://www.googletagmanager.com",
            "style-src 'self' 'unsafe-inline' https://www.google.com https://www.gstatic.com",
            "style-src-elem 'self' 'unsafe-inline' https://www.google.com https://www.gstatic.com https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com data:",
            "frame-src 'self' https://www.google.com https://www.gstatic.com https://www.youtube.com https://www.instagram.com",
            "frame-ancestors 'self' https://jdih.kemenkopangan.go.id https://*.kemenkopangan.go.id",
            "connect-src 'self' https://www.google.com https://www.gstatic.com https://cdn.jsdelivr.net https://www.google-analytics.com",
            "img-src 'self' data: https://www.google.com https://www.gstatic.com https://www.google-analytics.com https://*.cdninstagram.com",
        ];

        $response->headers->set(
            'Content-Security-Policy',
            implode('; ', $csp)
        );

        $response->headers->remove('X-Frame-Options');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=()');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}
