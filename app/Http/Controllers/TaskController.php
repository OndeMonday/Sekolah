<?php

namespace App\Http\Controllers;

use App\Handlers\TaskHandler;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class TaskController extends Controller
{
    protected TaskHandler $handler;

    public function __construct(TaskHandler $handler)
    {
        $this->handler = $handler;
    }
    public function deletetask(int $id):JsonResponse
    {
        try{
          $data = $this->handler->deletetask($id);
          return ok($data,'Berhasil Menghapus Task');
        }catch(Exception $e)
        {
        return serverError($e->getMessage());
        }
    }


    public function store(TaskRequest $request): JsonResponse
    {
        try {
            $guru = auth()->user();

          $result = $this->handler->store($guru, $request);
            if (isset($result['error'])) {
                return fail($result['error'], 400);
            }

            return created($result, 'Tugas berhasil dibuat');

        } catch (Exception $e) {
            return serverError('Gagal membuat tugas', $e->getMessage());
        }
    }


    public function tasksForStudent(Request $request): JsonResponse
    {
        try {
            $tasks = $this->handler->tasksForStudent($request->user()->nisn_nip);

            return ok($tasks, 'Berhasil mengambil daftar tugas siswa');

        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }

    public function taskbyteacher(): JsonResponse
    {
        try {
            $tasks = $this->handler->myTasks(auth()->id());

            return ok($tasks, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }


    public function taskbyclass(string $ClassName): JsonResponse
    {
        try {
            $teacher = auth()->user();

            $result = $this->handler->getTaskByTeacherAndTaskId($teacher, $ClassName);

            if (isset($result['error'])) {
                return notFound($result['error']);
            }

            return ok($result, 'Success');

        } catch (Exception $e) {
            return serverError('Terjadi kesalahan pada server', $e->getMessage());
        }
    }
}