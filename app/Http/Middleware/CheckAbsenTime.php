<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAbsenTime
{
    public function handle(Request $request, Closure $next): Response
    {
        $time = now()->format('H:i');

        $jamMasukStart = '06:00';
        $jamMasukEnd   = '07:30';

        $jamPulangStart = '14:00';
        $jamPulangEnd   = '15:00';

        $status = null;

        if ($time >= $jamMasukStart && $time <= $jamMasukEnd) {
            $status = 'masuk';
        } 
        elseif ($time >= $jamPulangStart && $time <= $jamPulangEnd) {
            $status = 'pulang';
        } 
        else {
            return response()->json([
                'message' => 'Diluar jam absen'
            ], 403);
        }

        $request->merge([
            'status_absen' => $status
        ]);

        return $next($request);
    }
}