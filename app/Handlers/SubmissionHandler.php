<?php
namespace App\Handlers;

use App\Repositories\SubmissionRepository;
use App\Http\Requests\SubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Http\Requests\ApproveSubmissionRequest;
use App\Repositories\TaskRepository;

class SubmissionHandler
{
    protected SubmissionRepository $repo;
    protected TaskRepository $taskRepo;

    public function __construct(SubmissionRepository $repo, TaskRepository $taskRepo)
    {
        $this->repo = $repo;
        $this->taskRepo = $taskRepo;
    }

public function getAll(string $id)
{
    return $this->repo->getAll($id);
}    

public function store(array $data, string $TaskId)
{

    $student = auth()->user();
    $now = now();

    $task = $this->taskRepo->findById($TaskId);
    if (!$task) {
        return null;
    }

    $status = $now->gt($task->deadline)
        ? 'late'
        : 'submitted';

    $data['student_id'] = $student->nisn_nip;
    $data['task_id'] = $TaskId;
    $data['submitted_at'] = $now;
    $data['status'] = $status;

    if (isset($data['image']) && $data['image']) {
        $data['image_path'] = $data['image']->store('submissions', 'public');
        unset($data['image']);
    }

    return $this->repo->create($data);
}

    public function update(string $TaskId, array $data,int $diri)//tollll
    {
        if (empty($data)) {
            return [
                "status" => false,
                "message" => "Tidak ada data dikirim",
                "data" => null
            ];
        }

        $submission = $this->repo->update($TaskId, $data,$diri);

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

public function approve(string $id,array $data)
    {
        $data['approved_at'] = now();
        return $this->repo->approve($id, $data);
    }


public function getByTaskId(string $id)
{
    return $this->repo->getByTaskId($id);
}
public function ceksub()
{
    return $this->repo->ceksub();
}
public function hapussub(int $TaskId, int $diri)
{
    return $this->repo->hapussub($TaskId, $diri);
}
Public function taskbyid(string $TaskId,int $diri)
{
    return $this->repo->taskbyid($TaskId,$diri);
}

}