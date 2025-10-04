<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $allowed = collect($roles)
            ->flatMap(function ($r) {
                return preg_split('/[,\|]/', (string) $r, -1, PREG_SPLIT_NO_EMPTY);
            })
            ->map(fn($r) => strtolower(trim($r)))
            ->filter()
            ->values()
            ->all();

        $user = $request->user();

        // Kalau belum login, biar middleware 'auth' yang handle — tapi berjaga-jaga:
        if (!$user) {
            return redirect()->guest(route('login'));
        }

        $userRole = strtolower((string) $user->role);

        // Jika tidak ada role yang disuplai, tolak
        if (empty($allowed)) {
            abort(403, 'Role is not specified.');
        }

        // Cek izin sederhana: role user harus ada di daftar allowed
        if (!in_array($userRole, $allowed, true)) {
            // JSON request → 403 JSON; selain itu → 403 halaman
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
