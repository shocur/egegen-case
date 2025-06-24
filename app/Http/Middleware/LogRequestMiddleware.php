<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RequestLog;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {        
        $response = $next($request);

        RequestLog::create([
            'ip' => $request->ip(),
            'method' => $request->method(),
            'status_code' => $response->getStatusCode(),
            'url' => $request->fullUrl(),
        ]);

        return $response;
    }
}
