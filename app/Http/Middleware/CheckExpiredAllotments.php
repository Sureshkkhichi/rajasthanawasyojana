<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\AllotmentExpiryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckExpiredAllotments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Throttle expiry check using Cache lock for 10 seconds during testing (was 300s)
        Cache::remember('system_allotment_expiry_check', 10, function () {
            try {
                app(AllotmentExpiryService::class)->expireOldAllotments();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('CheckExpiredAllotments middleware error: ' . $e->getMessage());
            }
            return now()->toDateTimeString();
        });

        return $next($request);
    }
}
