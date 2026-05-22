<?php

namespace App\Http\Controllers;

use Exception;
use App\Interfaces\DetailTransaksiInterface;
use App\Http\Requests\DetailTransaksi\DetailTransaksiRequest;
use App\Http\Requests\DetailTransaksi\DetailTransaksiUpdateRequest;

class DetailTransaksiController
extends Controller
{
    protected DetailTransaksiInterface
    $interface;

    public function __construct(
        DetailTransaksiInterface $interface
    ){
        $this->interface = $interface;
    }

    public function index()
    {
        try{

            $hasil = $this->interface
            ->get();

            return ok(
                $hasil,
                'Detail transaksi berhasil diambil'
            );

        }catch(Exception){

            return fail(
                'Gagal mengambil detail transaksi'
            );
        }
    }

    public function show(string $id)
    {
        try{

            $hasil = $this->interface
            ->detail($id);

            return ok(
                $hasil,
                'Detail transaksi berhasil diambil'
            );

        }catch(Exception){

            return fail(
                'Detail transaksi tidak ditemukan'
            );
        }
    }

    public function store(
        DetailTransaksiRequest $request
    ){
        try{

            $hasil = $this->interface
            ->create(
                $request->validated()
            );

            return created(
                $hasil,
                'Detail transaksi berhasil dibuat'
            );

        }catch(Exception){

            return fail(
                'Gagal membuat detail transaksi'
            );
        }
    }

    public function update(
        DetailTransaksiUpdateRequest $request,
        string $id
    ){
        try{

            $hasil = $this->interface
            ->update(
                $request->validated(),
                $id
            );

            return ok(
                $hasil,
                'Detail transaksi berhasil diubah'
            );

        }catch(Exception){

            return fail(
                'Gagal mengubah detail transaksi'
            );
        }
    }

    public function destroy(string $id)
    {
        try{

            $hasil = $this->interface
            ->delete($id);

            return ok(
                $hasil,
                'Detail transaksi berhasil dihapus'
            );

        }catch(Exception){

            return fail(
                'Gagal menghapus detail transaksi'
            );
        }
    }
}