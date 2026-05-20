<?php

namespace App\Http\Controllers;

use App\Handlers\PelanggaranHandler;
use App\Http\Requests\AddRequest;
use App\Http\Requests\EditRequest;
use App\Http\Resources\PelanggaranResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    protected PelanggaranHandler $handler;

    public function __construct(PelanggaranHandler $handler)
    {
        $this->handler = $handler;
    }
    public function addpelanggaran(AddRequest $request):JsonResponse
    {
                try {
            $data = $this->handler->addpelanggaran($request->validated());

            return ok($data, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }


    public function lihatpelanggaran():JsonResponse
    {
                        try {
            $tasks = $this->handler->lihatpelanggaran();

            return ok(PelanggaranResource::collection($tasks));

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }


    public function hapuspelanggaran(string $id):JsonResponse
    {
                       try {
            $tasks = $this->handler->hapuspelanggaran($id);

            return ok($tasks, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }

    public function editpelanggaran(string $id,EditRequest $request):JsonResponse
    {
                       try {
            $tasks = $this->handler->editpelanggaran($id,$request->validated());


            return ok($tasks, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }
    public function satupelanggaran(string $id):JsonResponse
        {
                        try {
            $tasks = $this->handler->satupelanggaran($id);

            return ok(
                 new PelanggaranResource($tasks),'');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }
}
