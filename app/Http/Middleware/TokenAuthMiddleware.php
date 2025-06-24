<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TokenAuthMiddleware
{
    private $validToken = '2BH52wAHrAymR7wP3CASt';
    private $maxAttempts = 10; // Tokensiz max deneme sayısı
    private $blockDuration = 600; // 10 dakika (saniye cinsinden)

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $blockedKey = "blocked:$ip";

        // Bearer Token kontrolü
        $authHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authHeader ?? '');

        // Eğer token doğruysa işlem devam etsin, hata sayısı sıfırlansın
        if ($token === $this->validToken) {
            Cache::forget("failed:$ip");
            return $next($request);
        }
        
        // Eğer IP bloklandıysa
        if (Cache::has($blockedKey)) {
            return response()->json([
                'message' => 'Bu IP geçici olarak engellendi.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Token yok veya yanlışsa
        $attemptsKey = "failed:$ip";
        $attempts = Cache::get($attemptsKey, 0) + 1;
        Cache::put($attemptsKey, $attempts, $this->blockDuration);

        if ($attempts >= $this->maxAttempts) {
            Cache::put($blockedKey, true, $this->blockDuration);
            Cache::forget($attemptsKey);
            return response()->json([
                'message' => 'Çok fazla hatalı istek. IP 10 dakika engellendi.'
            ], Response::HTTP_FORBIDDEN);
        }
        return $next($request);

        // return response()->json([
        //     'message' => "Token geçersiz veya eksik. Deneme sayısı: $attempts"
        // ], Response::HTTP_UNAUTHORIZED);
    }
}
