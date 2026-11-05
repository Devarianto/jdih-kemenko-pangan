<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ERegulasiController extends Controller
{
    /**
     * Resolve the official e-Regulasi target URL.
     * Checks CMS settings, Laravel config/services, environment variables, with safe fallback.
     */
    public static function getTargetUrl(): string
    {
        // 1. Check CMS Setting (Admin Panel configurable)
        try {
            if (function_exists('conf') && conf('site-setting')) {
                $cmsUrl = conf('site-setting')->value('eregulasi-url');
                if (!empty($cmsUrl) && filter_var($cmsUrl, FILTER_VALIDATE_URL)) {
                    return trim($cmsUrl);
                }
            }
        } catch (\Throwable $e) {
            // Silently fall through to config
        }

        // 2. Check Laravel services configuration (default: official portal root URL)
        $configUrl = config('services.eregulasi.base_url')
            ?? config('services.eregulasi.submission_url')
            ?? config('services.eregulasi.login_url');

        if (!empty($configUrl) && filter_var($configUrl, FILTER_VALIDATE_URL)) {
            return trim($configUrl);
        }

        // 3. Environment variable fallback
        $envUrl = env('EREGULASI_BASE_URL') ?? env('EREGULASI_SUBMISSION_URL');
        if (!empty($envUrl) && filter_var($envUrl, FILTER_VALIDATE_URL)) {
            return trim($envUrl);
        }

        // 4. Official default production endpoint
        return 'https://regulasikemenkopangan.id/';
    }

    /**
     * Direct redirect to the official e-Regulasi system.
     * Prevents open-redirect attacks and ensures appropriate headers are sent.
     */
    public function redirect(Request $request)
    {
        // 1. If admin is already authenticated, take them directly to the integrated Dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        // 2. In local environment or when running on localhost, direct to admin-panel login
        if (app()->environment('local') || in_array($request->getHost(), ['localhost', '127.0.0.1'])) {
            return redirect(config('cadmin.cadmin.admin-url', 'admin-panel'));
        }

        $targetUrl = self::getTargetUrl();

        // Security: Validate URL syntax and protocol
        if (!filter_var($targetUrl, FILTER_VALIDATE_URL) || (!str_starts_with($targetUrl, 'http://') && !str_starts_with($targetUrl, 'https://'))) {
            $targetUrl = 'https://regulasikemenkopangan.id/';
        }

        // Security: Verify host domain matches official government domains or local dev
        $host = parse_url($targetUrl, PHP_URL_HOST);
        $allowedHosts = [
            'regulasikemenkopangan.id',
            'www.regulasikemenkopangan.id',
            'localhost',
            '127.0.0.1'
        ];

        $isAllowed = false;
        foreach ($allowedHosts as $allowed) {
            if ($host === $allowed || str_ends_with($host, '.' . $allowed)) {
                $isAllowed = true;
                break;
            }
        }

        if (!$isAllowed && !str_ends_with($host, 'kemenkopangan.go.id')) {
            Log::warning('Blocked unauthorized e-Regulasi redirect attempt to: ' . $targetUrl);
            $targetUrl = 'https://regulasikemenkopangan.id/';
        }

        // Log redirection for audit/telemetry
        Log::info('e-Regulasi navigation requested by user. Redirecting to: ' . $targetUrl);

        return redirect()->away($targetUrl, 302, [
            'Referrer-Policy' => 'no-referrer-when-downgrade',
            'X-Frame-Options' => 'SAMEORIGIN',
        ]);
    }
}

