<?php

namespace App\Http\Controllers;

use App\Handlers\TaskHandler;
use App\Http\Requests\Tugas\TaskRequest;
use App\Http\Requests\Tugas\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Interfaces\TaskInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class TaskController extends Controller
{
    protected TaskHandler $handler;
    protected TaskInterface $interface;

    public function __construct(TaskHandler $handler,TaskInterface $interface)
    {
        $this->handler = $handler;
        $this->interface=$interface;
    }
    public function deletetask(string $id):JsonResponse
    {
        try{
          $data = $this->interface->deletetask($id);
          return ok($data,'Berhasil Menghapus Task');
        }catch(Exception)
        {
        return serverError('Gagal Menghapus Task');
        }
    }


    public function store(string $name ,TaskRequest $request): JsonResponse
    {
        try {
            $guru = auth()->user();

          $result = $this->handler->store($name, $request);
            if (isset($result['error'])) {
                return fail($result['error'], 400);
            }

            return created(new TaskResource($result), 'Tugas berhasil dibuat');

        } catch (Exception $e) {
            return serverError('Gagal membuat tugas', $e->getMessage());
        }
    }


    public function tasksForStudent(Request $request): JsonResponse
    {
        try {
            $tasks = $this->interface->getForStudent($request->user()->nisn_nip);

            return ok($tasks, 'Berhasil mengambil daftar tugas siswa');

        } catch (Exception) {
            return serverError('Gagal mengambil Tugas Siswa');
        }
    }

    public function taskbyteacher(): JsonResponse
    {
        try {
            $tasks = $this->interface->getTasksByTeacher(auth()->id());

            return ok($tasks, 'Berhasil mengambil tugas guru');

        } catch (Exception $e) {
            return serverError('Gagal mengambil tugas guru', $e->getMessage());
        }
    }
public function updatetask(UpdateTaskRequest $request, string $id): JsonResponse
{
    try {

        $result = $this->handler->updateTask($id, $request);

        if (isset($result['error'])) {
            return fail($result['error'], 400);
        }

        return ok($result, 'Tugas berhasil diperbarui');

    } catch (Exception $e) {
        return serverError('Gagal memperbarui tugas', $e->getMessage());
    }
}


    public function taskbyclass(string $name): JsonResponse
    {
        try {

            $result = $this->handler->getTaskByTeacherAndTaskId($name);

            if (isset($result['error'])) {
                return notFound($result['error']);
            }

            return ok($result, 'Success');

        } catch (Exception $e) {
            return serverError('Terjadi kesalahan pada server', $e->getMessage());
        }
    }
}