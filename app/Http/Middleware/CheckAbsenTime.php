<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAbsenTime
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $now = now();

        // =====================
        // IZIN / SAKIT
        // =====================

        if (
            in_array(
                $request->status_absen,
                ['izin', 'sakit']
            )
        ) {

            $izinStart = now()->setTime(6, 0);
            $izinEnd   = now()->setTime(18, 0);

            if (! $now->between($izinStart, $izinEnd)) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Izin/sakit hanya bisa dikirim jam 06:00 - 18:00'
                ], 403);
            }

            return $next($request);
        }

        // =====================
        // CEK LOKASI SEKOLAH
        // =====================

        $schoolLat = -8.109897995946582;
        $schoolLng = 112.04050813436716;

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        if (! $userLat || ! $userLng) {

            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak ditemukan'
            ], 400);
        }

        $distance = $this->distance(
            $userLat,
            $userLng,
            $schoolLat,
            $schoolLng
        );

        // maksimal 180 meter
        if ($distance > 180) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Terlalu Jauh Dari Area Sekolah',
                'distance' =>
                    round($distance).' meter'
            ], 403);
        }

        // =====================
        // ABSEN MASUK
        // =====================

        $jamMasukStart = now()->setTime(9, 0);
        $jamMasukEnd   = now()->setTime(13, 15);

        // =====================
        // TERLAMBAT
        // =====================

        $jamTerlambatEnd = now()->setTime(13, 50);

        // =====================
        // PULANG
        // =====================

        $jamPulangStart = now()->setTime(15, 0);
        $jamPulangEnd   = now()->setTime(16, 30);

        // masuk
        if ($now->between($jamMasukStart, $jamMasukEnd)) {

            $request->merge([
                'status_absen' => 'masuk'
            ]);
        }

        // terlambat
        elseif (
            $now->between(
                $jamMasukEnd,
                $jamTerlambatEnd
            )
        ) {

            $request->merge([
                'status_absen' => 'terlambat'
            ]);
        }

        // pulang
        elseif (
            $now->between(
                $jamPulangStart,
                $jamPulangEnd
            )
        ) {

            $request->merge([
                'status_absen' => 'pulang'
            ]);
        }

        else {

            return response()->json([
                'success' => false,
                'message' => 'Diluar jam absensi'
            ], 403);
        }

        return $next($request);
    }

    // =====================
    // HITUNG JARAK
    // =====================

    private function distance(
    float $lat1,
    float $lon1,
    float $lat2,
    float $lon2
): float {

        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) *
            sin($dLat / 2) +

            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *

            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );

        return $earthRadius * $c;
    }
}