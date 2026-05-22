<?php

namespace App\Http\Controllers;

use App\Handlers\AbsenHandler;
use App\Interfaces\AbsenInterface;
use Illuminate\Http\Request;
use Exception;

class AbsenController extends Controller
{
    protected AbsenHandler $handler;
    protected AbsenInterface $interface;

    public function __construct(AbsenHandler $handler, AbsenInterface $interface)
    {
        $this->handler = $handler;
        $this->interface = $interface;
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'foto' => 'required'
            ]);

            $result = $this->handler->store($request, $request->user());

            if (!$result['success']) {
                return serverError($result['message']);
            }

            return created($result['data'], $result['message']);

        } catch (Exception $e) {
            return serverError('Gagal absen', $e->getMessage());
        }
    }

    public function index()
    {
        try {
            $data = $this->interface->all();

            return ok($data, 'Berhasil mengambil data absensi');

        } catch (Exception $e) {
            return serverError('Gagal mengambil data absensi', $e->getMessage());
        }
    }

    public function myAbsensi(Request $request)
    {
        try {
            $data = $this->interface->findByUser($request->user()->id);

            return ok($data, 'Berhasil mengambil data absensi user');

        } catch (Exception $e) {
            return serverError('Gagal mengambil data user absensi', $e->getMessage());
        }
    }
}