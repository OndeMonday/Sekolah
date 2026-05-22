<?php

namespace App\Handlers;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;

class AbsenHandler
{
    public function store(Request $request, User $user)
    {
        $path = $request->file('foto')->store('absensi', 'public');

        $status = $request->status_absen;

        $sudah = Absen::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->where('status', $status)
            ->exists();

        if ($sudah) {
            return [
                'success' => false,
                'message' => "Sudah absen $status hari ini"
            ];
        }

        $absen = Absen::create([
            'user_id' => $user->id,
            'foto' => $path,
            'status' => $status,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return [
            'success' => true,
            'message' => 'Absen berhasil',
            'data' => $absen
        ];
    }
}   