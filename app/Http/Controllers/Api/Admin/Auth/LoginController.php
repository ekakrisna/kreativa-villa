<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Auth\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\TransientToken;

class LoginController extends Controller
{
    use ApiResponse;

    /**
     * Admin login (issue Sanctum token)
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Hanya admin/super_admin yang boleh lewat
        if (! in_array($user->role, ['admin', 'super_admin'], true)) {
            return $this->errorResponse('Forbidden: admin only.', 403);
        }

        // Single-login policy (opsional)
        $user->tokens()->delete();

        $token = $user->createToken(
            name: $request->input('device_name') ?: 'admin_auth',
            abilities: ['admin:*'],
            expiresAt: now()->addDay()
        );

        return $this->successResponse([
            'token'      => $token->plainTextToken,
            'token_type' => 'Bearer',
            'user'       => $user,
        ], 'Login successful');
    }

    /**
     * Admin logout (revoke current token)
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();

        if ($token && !($token instanceof TransientToken)) {
            $token->delete();
        }

        return $this->successResponse((bool) $token, 'Logout successful.');
    }

    /**
     * Current admin info
     */
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse([
            'user'      => $request->user(),
            'abilities' => $request->user()->currentAccessToken()?->abilities ?? [],
        ]);
    }

    /**
     * Logout all sessions for this admin (opsional)
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $token = $request->user()->tokens()->delete();
        return $this->successResponse((bool)$token, 'Logged out from all devices.');
    }
}
