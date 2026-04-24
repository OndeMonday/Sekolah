<?php

namespace App\Http\Controllers;

use App\Handlers\ClassHandler;
use App\Http\Requests\AssignStudentRequest;
use App\Http\Requests\AssignTeacherRequest;
use App\Http\Requests\BuatKelasRequest;
use App\Http\Requests\GantiNama;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

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


    public function hapuskelas(string $id)
    {
        try {
            $data = $this->handler->hapuskelas($id);
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
            return created($data, 'Siswa berhasil ditambahkan ke kelas');
        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }


public function assignTeachers(string $kelas, AssignTeacherRequest $request)
    {
    try {
        $teachers = $request->validated();

        $teachers = isset($teachers['user_id'])
            ? [$teachers]
            : $teachers;

        $data = $this->handler->assignTeachers($kelas, $teachers);

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil ditambahkan ke kelas',
            'data' => $data
        ], 201);

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error',
            'error' => $e->getMessage()
        ], 500);
    }
    }


public function isikelas(string $className, Request $request)
    {
        try {
            $result = $this->handler->getUsersByClass($className);

            if ($request->query('format') === 'pdf') {
                $pdf = Pdf::loadView('admin.class_pdf', [
                    'users' => $result['users'],
                    'class' => $result['class']
                ]);

                return $pdf->download('kelas_'.$className.'.pdf');
            }

            return ok($result, 'Berhasil mengambil data user');

        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }
}