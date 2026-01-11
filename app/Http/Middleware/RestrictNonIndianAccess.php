<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class RestrictNonIndianAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $position = Location::get($request->ip());
        // FacadesLog::info('User IP: ' . $request->ip());
        // FacadesLog::info('User Location: ' . json_encode($position));
        // FacadesLog::info('User Country Code: ' . ($position->countryCode ?? 'Unknown'));
        // FacadesLog::info('User Country Name: ' . ($position->countryName ?? 'Unknown'));

        if ($position && $position->countryCode !== 'IN') {
            abort(403, 'Access restricted to Indian users only.');
        }

        return $next($request);
    }
}
