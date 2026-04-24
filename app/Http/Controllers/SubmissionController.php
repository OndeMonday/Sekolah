<?php

namespace App\Http\Controllers;

use App\Handlers\SubmissionHandler;
use App\Http\Requests\SubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Http\Requests\ApproveSubmissionRequest;
use Illuminate\Http\JsonResponse;
use Exception;

class SubmissionController extends Controller
{
    protected SubmissionHandler $handler;

    public function __construct(SubmissionHandler $handler)
    {
        $this->handler = $handler;
    }


    public function store(SubmissionRequest $request): JsonResponse
    {
        try {
            $submission = $this->handler->store($request->validated());

            return created($submission, 'Tugas berhasil dikirim');

        } catch (Exception $e) {
            return serverError('Gagal mengirim tugas', $e->getMessage());
        }
    }


    public function update(int $id, UpdateSubmissionRequest $request): JsonResponse
    {
        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['image_path'] = $request->file('image')->store('submissions', 'public');
            }

            $result = $this->handler->update($id, $data);

            if (!$result['status']) {
                return fail($result['message'], 400);
            }

            return ok($result['data'], $result['message']);

        } catch (Exception $e) {
            return serverError($e->getMessage());
        }
    }

    public function approved(ApproveSubmissionRequest $request, int $id): JsonResponse
    {
        try {
            $submission = $this->handler->approve($id, $request->validated());

            return ok($submission, 'Submission berhasil diperbarui');

        } catch (Exception $e) {
            return serverError('Gagal meng-approve submission', $e->getMessage());
        }
    }


    public function index(int $taskId): JsonResponse
    {
        try {
            $submission = $this->handler->getByTaskId($taskId);

            return ok($submission, 'Berhasil mengambil daftar submission');

        } catch (Exception $e) {
            return serverError('Gagal mengambil daftar submission', $e->getMessage());
        }
    }
}