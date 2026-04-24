<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Handlers\PelanggaranHandler;
use App\Http\Requests\TipePelanggaranRequest;
use App\Http\Requests\UpdatePelanggaranRequest;

class PelanggaranController extends Controller
{
    protected PelanggaranHandler $handler;

    public function __construct(PelanggaranHandler $handler)
    {
        $this->handler = $handler;
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function tipepelanggaran(TipePelanggaranRequest $request): JsonResponse
    {
                try {
            $data = $this->handler->tipepelanggaran($request->validated());

            return created($data, 'Tugas berhasil dikirim');

        } catch (Exception $e) {
            return serverError('Gagal mengirim tugas', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function listpelanggaran(): JsonResponse
    {
        try {
            $data = $this->handler->listpelanggaran([]);

            return ok($data, 'Daftar pelanggaran berhasil diambil');

        } catch (Exception $e) {
            return serverError('Gagal mengambil daftar pelanggaran', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function updatepelanggaran (string $id, Request $request): JsonResponse
    {
        try {
            $data = $this->handler->updatepelanggaran($id, $request->all());
            return ok($data, 'Pelanggaran berhasil diperbarui');

        } catch (Exception $e) {
            return serverError('Gagal memperbarui pelanggaran', $e->getMessage());
        }
    }

        public function deletepelanggaran(string $id): JsonResponse
        {
            try {
                $data = $this->handler->deletepelanggaran($id);
                return ok($data, 'Pelanggaran berhasil dihapus');
    
            } catch (Exception $e) {
                return serverError('Gagal menghapus pelanggaran', $e->getMessage());
            }
        }   

}
