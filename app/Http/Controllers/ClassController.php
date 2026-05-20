<?php

namespace App\Http\Controllers;

use App\Handlers\ClassHandler;
use App\Http\Requests\AssignStudentRequest;
use App\Http\Requests\AssignTeacherRequest;
use App\Http\Requests\BuatKelasRequest;
use App\Http\Requests\GantiNama;
use App\Http\Resources\GuruResource;
use App\Http\Resources\MuridResource;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

use function PHPUnit\Framework\returnArgument;

class ClassController extends Controller
{
    protected ClassHandler $handler;

    public function __construct(ClassHandler $handler)
    {
        $this->handler = $handler;
    }


    public function daftarkelas()
    {
        try {
            $data = $this->handler->daftarkelas();
            return ok($data, 'Berhasil mengambil daftar kelas');
        } catch (Exception $e) {
            return serverError('Gagal mengambil daftar kelas', $e->getMessage());
        }
    }


    public function buatkelas(BuatKelasRequest $request)
    {
        try {
            $data = $this->handler->buatkelas($request->validated());
            return created($data, 'Kelas berhasil dibuat');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


    public function hapuskelas(string $name)
    {
        try {
            $data = $this->handler->hapuskelas($name);
            return ok($data, 'Kelas berhasil dihapus');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


    public function gantinama(string $url, GantiNama $request)
    {
        try {
            $data = $this->handler->gantinama($url, $request->validated());
            return ok($data, 'Nama kelas berhasil diganti');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


    public function assignStudents(AssignStudentRequest $request, string $kelas)
    {
        try {
            $data = $this->handler->assignStudents($kelas, $request->validated()['siswa']);
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

    } catch (Exception $e) {
            return serverError($e->getMessage());
    }
    }


public function isikelas(string $kelas, Request $request)
    {
        try {
            $result = $this->handler->getUsersByClass($kelas);

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
            $data = $this->handler->kelasajar($teacherId);
            return ok($data, 'Berhasil mengambil data kelas yang diajar');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }
   public function removemurid(string $nisn)
{
    try {
        $hasil = $this->handler->removemurid($nisn);

        if ($hasil === 0) {
            return serverError('Murid tidak ditemukan di kelas');
        }

        return ok($hasil, 'berhasil menghapus murid');

    } catch (\Exception $e) {
        return serverError($e->getMessage());
    }
}
}