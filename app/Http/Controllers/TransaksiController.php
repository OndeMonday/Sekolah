<?php

namespace App\Http\Controllers;

use Exception;
use App\Interfaces\TransaksiInterface;
use App\Http\Requests\Transaksi\TransaksiRequest;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    protected TransaksiInterface $interface;

    public function __construct(TransaksiInterface $interface)
    {
        $this->interface = $interface;
    }

    public function index()
    {
        try {

            $hasil = $this->interface->get();

            return ok(
                $hasil,
                'Transaksi berhasil diambil'
            );

        } catch (Exception) {

            return fail(
                'Gagal mengambil transaksi'
            );
        }
    }

    public function show(string $id)
    {
        try {

            $hasil = $this->interface->detail($id);

            return ok(
                $hasil,
                'Detail transaksi berhasil diambil'
            );

        } catch (Exception) {

            return fail(
                'Detail transaksi tidak ditemukan'
            );
        }
    }

    public function store(TransaksiRequest $request)
    {
        try {

            $hasil = $this->interface->create(
                $request->validated()
            );

            return created(
                $hasil,
                'Transaksi berhasil dibuat'
            );

        } catch (Exception $e) {

            return fail(
                $e->getMessage()
            );
        }
    }

    public function callback(Request $request)
    {
        try {

            $hasil = $this->interface->callback($request);

            return ok(
                $hasil,
                'Callback berhasil'
            );

        } catch (Exception) {

            return fail(
                'Callback gagal'
            );
        }
    }
}