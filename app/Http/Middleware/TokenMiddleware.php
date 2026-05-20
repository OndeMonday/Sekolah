<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json([
                'message' => 'Invalid token'
            ], 401);
        }

        if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {

            $accessToken->delete();

            return response()->json([
                'message' => 'Token expired'
            ], 401);
        }

        return $next($request);
    }
}