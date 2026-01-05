<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->header('language-encoding');

        if (!$locale || !in_array($locale, ['ar', 'en'])) {
            $locale = $request->header('Accept-Language', 'en');
            // Extract first 2 chars if it's like en-US
            $locale = substr($locale, 0, 2);
        }

        if (in_array($locale, ['ar', 'en'])) {
            app()->setLocale($locale);
        }

    return $next($request);
}
}
