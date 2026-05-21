<?php

namespace App\Http\Controllers;

use App\Http\Requests\Laporan\AddLaporanRequest;
use App\Http\Requests\Laporan\EditLaporanRequest;
use App\Http\Requests\Laporan\NilaiLaporanRequest;
use App\Http\Requests\EditRequest;
use App\Interfaces\LaporanInterface;
use App\Http\Resources\Laporan\LaporanResource;
use App\Http\Resources\Laporan\AdminLaporanResource;
use App\Http\Resources\Laporan\AddLaporanResource;
use App\Handlers\LaporanHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    protected LaporanHandler $handler;
    protected LaporanInterface $interface;

    public function __construct(LaporanHandler $handler,LaporanInterface $interface)
    {
        $this->handler = $handler;
        $this->interface = $interface;
    }
    public function addlaporan(AddLaporanRequest $request):JsonResponse
    {
        try {
             $data = $this->handler->addlaporan($request->validated(), $request);
             return ok(new AddLaporanResource($data), 'Berhasil menambahkan laporan');

        }catch (Exception ) {
             return serverError('Gagal menambahkan laporan');
        }
    }


    public function lihatlaporan():JsonResponse
    {
        try{
            $tasks = $this->interface->get();

            return ok(AddLaporanResource::collection($tasks));

        }catch (Exception ) {
            return serverError('Gagal mengambil tugas guru');
        }
    }


    public function hapuslaporan(string $id):JsonResponse
    {
        try{
            $tasks = $this->interface->delete($id);

            return ok($tasks, 'Berhasil mengambil tugas guru');

        }catch (Exception ) {
            return serverError('Gagal mengambil tugas guru');
        }
    }

    public function editlaporan(string $id,EditLaporanRequest $request):JsonResponse
    {
        try{
            $tasks = $this->handler->editlaporan($id,$request->validated(), $request);


            return ok(new AddLaporanResource($tasks), 'Berhasil mengambil tugas guru');

        }catch (Exception) {
            return serverError('Gagal mengambil tugas guru');
        }
    }
    
    public function satulaporan(string $laporanid):JsonResponse
        {
           try {
                $tasks = $this->interface->satu($laporanid);

                return ok( new AdminLaporanResource($tasks));

          }catch (Exception) {
                return serverError('Gagal mengambil tugas guru');
        }
    }
public function pelanggaranorang(string $userid, Request $request): JsonResponse
{ 
    try{
        $laporan = $this->interface->laporanorang($userid,$request->query('search'));
        return response()->json([
        'data' => AdminLaporanResource::collection($laporan['data']),
        'total_poin' => $laporan['total_poin']
    ]);
    }catch(Exception){
        return notFound('Data Tidak Ditemukan');
}
}
    public function jenislaporan(string $pelanggaranid,Request $request):JsonResponse
    {
        try{
             $laporan=$this->interface->jenislaporan($pelanggaranid,$request->query('search'));
             return AdminLaporanResource::collection($laporan)->response();
        }catch(Exception){
             return notFound('Tidak Dapat Ditemukan');
    }
}
public function laporansemua(Request $request)
{
    try{
        $laporan=$this->interface->laporansemua($request->query('search'));
        return (AdminLaporanResource::collection($laporan));
    }catch(Exception){
        return notFound('Tidak Ditemukan');
    }
      
}
public function pelanggaransaya(Request $request): JsonResponse
{
    try {
        $userid = $request->user()->nisn_nip;

        $laporan = $this->interface->pelanggaransaya($userid);

        return response()->json([
            'data' => AdminLaporanResource::collection($laporan['data']),
            'total_poin' => $laporan['total_poin'],
            'message' => $laporan['message']
        ]);

    } catch (Exception) {
        return notFound('Data Tidak Ditemukan');
    }
}
public function nilailaporan(string $laporanid,NilaiLaporanRequest $request): JsonResponse
{
    try {
        $laporan = $this->interface->nilai($laporanid,$request->validated());
return ok('berhasil dinilai',($laporan));

    } catch (Exception) {
        return serverError('Gagal mengambil nilai laporan');
    }
}
}