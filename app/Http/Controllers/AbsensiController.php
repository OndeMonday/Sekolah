<?php

namespace App\Http\Controllers;

use App\Handlers\AbsensiHandler;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;
use App\Interfaces\AbsensiInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    protected AbsensiHandler $handler;

    protected AbsensiInterface $interface;

    public function __construct(
        AbsensiHandler $handler,
        AbsensiInterface $interface
    ) {
        $this->handler = $handler;
        $this->interface = $interface;
    }

    public function store(
        StoreAbsensiRequest $request
    ): JsonResponse {
        try {

            $absensi = $this->handler->store($request);

            return response()->json([
                'message' => 'Berhasil absen',
                'data' => $absensi
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function myAbsensi(): JsonResponse
    {
        try {

            $absensi = $this->interface->myAbsensi(
                auth()->user()->nisn_nip
            );

            return response()->json([
                'message' => 'Berhasil mengambil data absensi',
                'data' => $absensi
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function index(Request $request): JsonResponse
    {
        try {

            $absensi = $this->interface->index($request);

            return response()->json([
                'message' => 'Berhasil mengambil data absensi',
                'data' => $absensi
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
public function exportPdf(Request $request)
    {
        try {

            $request->validate([
                'kelas' => 'required|string',
                'bulan' => 'required|integer|min:1|max:12',
                'tahun' => 'required|integer'
            ]);

            return $this->handler->exportPdf($request);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}