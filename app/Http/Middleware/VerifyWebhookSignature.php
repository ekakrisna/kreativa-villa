<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $provider): Response
    {
        if ($provider === 'xendit') {
            $header = $request->header('X-CALLBACK-TOKEN');
            $expected = config('services.xendit.callback_token');
            abort_unless($header && hash_equals($expected, $header), 401, 'Invalid signature');
        }
        return $next($request);
    }
}
