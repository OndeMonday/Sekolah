<?php

namespace App\Http\Controllers;

use Exception;
use App\Interfaces\MenuInterface;
use App\Http\Requests\Menu\MenuRequest;
use App\Http\Requests\Menu\MenuUpdateRequest;
use Illuminate\Http\Request;
class MenuController extends Controller
{
    protected MenuInterface $interface;

    public function __construct(MenuInterface $interface)
    {
        $this->interface = $interface;
    }

    public function index()
    {
        try{

            $hasil = $this->interface->get();

            return ok(
                $hasil,
                'Menu berhasil diambil'
            );

        }catch(Exception){

            return fail(
                'Gagal mengambil menu'
            );
        }
    }

    public function show(string $id)
    {
        try{

            $hasil = $this->interface->detail($id);

            return ok(
                $hasil,
                'Detail menu berhasil diambil'
            );

        }catch(Exception){

            return fail(
                'Menu tidak ditemukan'
            );
        }
    }

    public function store(MenuRequest $request)
    {
        try{

            $hasil = $this->interface->create(
                $request->validated()
            );

            return created(
                $hasil,
                'Menu berhasil ditambahkan'
            );

        }catch(Exception){

            return fail(
                'Gagal menambahkan menu'
            );
        }
    }

    public function update(
        MenuUpdateRequest $request,
        string $id
    ){
        try{

            $hasil = $this->interface->update(
                $request->validated(),
                $id
            );

            return ok(
                $hasil,
                'Menu berhasil diubah'
            );

        }catch(Exception){

            return fail(
                'Gagal mengubah menu'
            );
        }
    }

    public function destroy(string $id)
    {
        try{

            $hasil = $this->interface->delete($id);

            return ok(
                $hasil,
                'Menu berhasil dihapus'
            );

        }catch(Exception){

            return fail(
                'Gagal menghapus menu'
            );
        }
    }
    public function tambah(string $menuid,Request $request)
    {
        try{

            $hasil = $this->interface->tambah($menuid,$request->stok);

            return ok(
                $hasil,
                'Stok menu berhasil ditambahkan'
            );

        }catch(Exception){

            return fail(
                'Menu tidak ditemukan'
            );
        }
    }
}