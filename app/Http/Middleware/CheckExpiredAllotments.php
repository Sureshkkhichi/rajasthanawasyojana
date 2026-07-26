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
        // Throttle expiry check using Cache lock for 5 minutes (300 seconds)
        Cache::remember('system_allotment_expiry_check', 300, function () {
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
