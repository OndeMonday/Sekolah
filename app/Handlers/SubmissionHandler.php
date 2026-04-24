<?php
namespace App\Handlers;

use App\Repositories\SubmissionRepository;
use App\Http\Requests\SubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Http\Requests\ApproveSubmissionRequest;
use App\Models\Submission;

class SubmissionHandler
{
    protected SubmissionRepository $repo;

    public function __construct(SubmissionRepository $repo)
    {
        $this->repo = $repo;
    }

public function store(array $data)
{
    $student = auth()->user();

    $data['student_id'] = $student->nisn_nip;
    $data['submitted_at'] = now();

    if (request()->hasFile('image')) {
        $data['image_path'] = request()->file('image')->store('submissions', 'public');
    }

    return $this->repo->create($data);
}

    public function update(int $id, array $data)
    {
        if (empty($data)) {
            return [
                "status" => false,
                "message" => "Tidak ada data dikirim",
                "data" => null
            ];
        }

        $submission = $this->repo->update($id, $data);

        if (!$submission) {
            return [
                "status" => false,
                "message" => "Data tidak ditemukan",
                "data" => null
            ];
        }

        return [
            "status" => true,
            "message" => "Berhasil update",
            "data" => $submission
        ];
    }

public function approve(int $id, ApproveSubmissionRequest $request)
    {
        $data = $request->validated();
        $data['approved_at'] = now();
        return $this->repo->approve($id, $data);
    }

public function getByTaskId($taskId)
{
    return $this->repo->getByTaskId($taskId);
}
}