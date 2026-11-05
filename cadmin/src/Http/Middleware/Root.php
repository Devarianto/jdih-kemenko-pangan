<?php namespace Cactuar\Admin\Http\Middleware;

use Closure;
use Validator;
use Cactuar\Admin\Helpers\lang;
use Cactuar\Admin\Helpers\recaptcha;

class Root
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {	
      Validator::extend('recaptcha', function($attr, $value, $param) {
        return recaptcha::validate($value);
      });
      Validator::extend('recaptchaV3', function($attr, $value, $param) {
        return recaptcha::validateV3($value);
      });

      //penambahan header
		  $response = $next($request);
      $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
      $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
      $response->headers->set('X-Content-Type-Options', 'nosniff');
      $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
      $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=()');
      $response->headers->set('X-XSS-Protection', '1; mode=block');
      
      $csp = "default-src 'self'; ";
      $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://www.gstatic.com https://www.google.com https://www.recaptcha.net https://maps.googleapis.com https://www.youtube.com; ";
      $csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://www.gstatic.com https://www.google.com https://www.recaptcha.net https://maps.googleapis.com https://www.youtube.com; ";
      $csp .= "img-src 'self' data: https://www.google.co.id https://www.google-analytics.com https://www.googletagmanager.com https://maps.googleapis.com https://maps.gstatic.com https://www.google.com https://www.gstatic.com https://www.youtube.com https://i.ytimg.com; ";
      $csp .= "frame-src 'self' https://www.youtube.com https://www.google.com https://www.recaptcha.net; ";
      $csp .= "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; ";
      $csp .= "connect-src 'self' https://analytics.google.com https://www.google-analytics.com https://www.googletagmanager.com https://maps.googleapis.com https://www.google.com https://www.gstatic.com; ";
      $csp .= "child-src 'self' https://www.youtube.com https://www.google.com https://www.recaptcha.net; ";
      $csp .= "object-src 'self'; ";
      $csp .= "base-uri 'self'; ";
      $csp .= "form-action 'self'; ";
      $csp .= "frame-ancestors 'self'; ";
      $csp .= "block-all-mixed-content; ";
      $csp .= "upgrade-insecure-requests; ";
      $response->headers->set('Content-Security-Policy', $csp);

      return $response;
    }
}
