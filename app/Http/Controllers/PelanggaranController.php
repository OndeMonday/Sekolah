<?php

namespace App\Http\Controllers;

use App\Handlers\PelanggaranHandler;
use App\Http\Requests\Pelanggaran\AddPelanggaranRequest;
use App\Http\Requests\Pelanggaran\EditRequest;
use App\Http\Resources\PelanggaranResource;
use App\Interfaces\PelanggaranInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    protected PelanggaranHandler $handler;
    protected PelanggaranInterface $interface;

    public function __construct(PelanggaranHandler $handler,PelanggaranInterface $interface)
    {
        $this->handler = $handler;
        $this->interface = $interface;
    }
    public function addpelanggaran(AddPelanggaranRequest $request):JsonResponse
    {
                try {
            $data = $this->interface->create($request->validated());

            return ok($data, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }


    public function lihatpelanggaran():JsonResponse
    {
                        try {
            $tasks = $this->interface->get();

            return ok(PelanggaranResource::collection($tasks));

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }


    public function hapuspelanggaran(string $id):JsonResponse
    {
                       try {
            $tasks = $this->interface->delete($id);

            return ok($tasks, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }

    public function editpelanggaran(string $id,EditRequest $request):JsonResponse
    {
                       try {
            $tasks = $this->interface->update($id,$request->validated());


            return ok($tasks, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }
    public function satupelanggaran(string $id):JsonResponse
        {
                        try {
            $tasks = $this->interface->satu($id);

            return ok(
                 new PelanggaranResource($tasks),'');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }
}
