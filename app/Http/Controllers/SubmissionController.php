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
    public function getAll(): JsonResponse
    {
        try {
            $id = auth()->user()->nisn_nip; 
            $submission = $this->handler->getAll($id);

            return ok($submission, 'Berhasil mengambil daftar submission');

        } catch (Exception $e) {
            return serverError('Gagal mengambil daftar submission', $e->getMessage());
        }
    }


    public function store(SubmissionRequest $request,int $TaskId): JsonResponse
    {
        try {
            
            $submission = $this->handler->store($request->validated(),$TaskId);

            return created($submission, 'Tugas berhasil dikirim');

        } catch (Exception $e) {
            return serverError('Gagal mengirim tugas', $e->getMessage());
        }
    }


    public function update(int $TaskId, UpdateSubmissionRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $diri = auth()->user()->nisn_nip;

            if ($request->hasFile('image')) {
    $data['image_path'] = $request->file('image')->store('submissions', 'public');
}
            

            $result = $this->handler->update($TaskId, $data,$diri);

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


    public function index(int $id): JsonResponse
    {
        try {
            $submission = $this->handler->getByTaskId($id);

            return ok($submission, 'Berhasil mengambil daftar submission');

        } catch (Exception $e) {
            return serverError('Gagal mengambil daftar submission', $e->getMessage());
        }
    }
    public function ceksub(): JsonResponse
    {
        try {
            $submission = $this->handler->ceksub();

            if (!$submission) {
                return notFound('Submission tidak ditemukan');
            }

            return ok($submission, 'Berhasil mengambil submission');

        } catch (Exception $e) {
            return serverError('Gagal mengambil submission', $e->getMessage());
        }
}
public function taskbyid(int $TaskId): JsonResponse
{
    try {
        $diri = auth()->user()->nisn_nip;
        $submission = $this->handler->taskbyid($TaskId,$diri);

        if (!$submission) {
            return notFound('Submission tidak ditemukan');
        }

        return ok($submission, 'Berhasil mengambil submission');

    } catch (Exception $e) {
        return serverError('Gagal mengambil submission', $e->getMessage());
    }

}
public function hapussub(int $TaskId): JsonResponse
{
    try {
        $diri = auth()->user()->nisn_nip;
        $result = $this->handler->hapussub($TaskId, $diri);

        if (!$result) {
            return notFound('Submission tidak ditemukan');
        }

        return ok(null, 'Submission berhasil dihapus');

    } catch (Exception $e) {
        return serverError('Gagal menghapus submission', $e->getMessage());
    }
}
}