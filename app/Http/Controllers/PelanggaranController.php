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
            $submission = $this->handler->tipepelanggaran($request->validated());

            return created($submission, 'Tugas berhasil dikirim');

        } catch (Exception $e) {
            return serverError('Gagal mengirim tugas', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
