<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAbsenTime
{
    public function handle(Request $request, Closure $next): Response
    {
        $now = now();

        $jamMasukStart = now()->setTime(13, 0);
        $jamMasukEnd   = now()->setTime(13, 50);

        $jamPulangStart = now()->setTime(15, 0);
        $jamPulangEnd   = now()->setTime(16, 30);

        if ($now->between($jamMasukStart, $jamMasukEnd)) {

            $request->merge([
                'status_absen' => 'masuk'
            ]);

        } elseif ($now->between($jamPulangStart, $jamPulangEnd)) {

            $request->merge([
                'status_absen' => 'pulang'
            ]);

        } else {

            return response()->json([
                'message' => 'Diluar jam absensi'
            ], 403);
        }

        return $next($request);
    }
}