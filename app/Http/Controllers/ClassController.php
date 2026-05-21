<?php

namespace App\Http\Controllers;

use App\Handlers\ClassHandler;
use App\Http\Requests\Kelas\AssignStudentRequest;
use App\Http\Requests\Kelas\AssignTeacherRequest;
use App\Http\Requests\Kelas\BuatKelasRequest;
use App\Http\Requests\Kelas\GantiNama;
use App\Http\Resources\GuruResource;
use App\Http\Resources\MuridResource;
use App\Interfaces\ClassInterface;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

use function PHPUnit\Framework\returnArgument;

class ClassController extends Controller
{
    protected ClassHandler $handler;
    protected ClassInterface $interface;

    public function __construct(ClassHandler $handler,ClassInterface $interface)
    {
        $this->handler = $handler;
        $this->interface = $interface;
    }


    public function daftarkelas()
    {
        try {
            $data = $this->interface->all();
            return ok($data, 'Berhasil mengambil daftar kelas');
        } catch (Exception $e) {
            return serverError('Gagal mengambil daftar kelas', $e->getMessage());
        }
    }


    public function buatkelas(BuatKelasRequest $request)
    {
        try {
            $data = $this->interface->create($request->validated());
            return created($data, 'Kelas berhasil dibuat');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


    public function hapuskelas(string $name)
    {
        try {
            $data = $this->interface->delete($name);
            return ok($data, 'Kelas berhasil dihapus');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


    public function gantinama(string $url, GantiNama $request)
    {
        try {
            $data = $this->interface->update($url, $request->validated());
            return ok($data, 'Nama kelas berhasil diganti');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


    public function assignStudents(AssignStudentRequest $request, string $kelas)
    {
        try {
            $data = $this->interface->assignStudents($kelas, $request->validated()['siswa']);
            return created(MuridResource::collection($data), 'Siswa berhasil ditambahkan ke kelas');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


public function assignTeachers(string $kelas, AssignTeacherRequest $request)
    {
    try {
        $teachers = $request->validated();

        $teachers = isset($teachers['nisn_nip'])
            ? [$teachers]
            : $teachers;

        $data = $this->handler->assignTeachers($kelas, $teachers);

        return created($data,'Berhasil Ditambahkan');

    } catch (Exception) {
            return serverError('gagal assign guru');
    }
    }

public function isikelas(string $kelas, Request $request)
    {
        try {
            $result = $this->interface->getUsersByClass($kelas);

            if ($request->query('format') === 'pdf') {
                $pdf = Pdf::loadView('admin.class_pdf', [
                    'users' => $result['users'],
                    'class' => $result['class']
                ]);

                return $pdf->download('kelas_'.$kelas.'.pdf');
            }

            return ok($result, 'Berhasil mengambil data user');

        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }
    public function kelasajar(Request $request)
    {
        try {
            $teacherId = $request->user()->nisn_nip;
            $data = $this->interface->kelasajar($teacherId);
            return ok($data, 'Berhasil mengambil data kelas yang diajar');
        } catch (Exception) {
            return serverError('Kelas Tidak Ditemukan');
        }
    }
   public function removemurid(string $nisn)
{
    try {
        $hasil = $this->interface->removemurid($nisn);

        if ($hasil === 0) {
            return serverError('Murid tidak ditemukan di kelas');
        }

        return ok($hasil, 'berhasil menghapus murid');

    } catch (Exception) {
        return serverError('Murid Tidak Ditemukan');
    }
}
}