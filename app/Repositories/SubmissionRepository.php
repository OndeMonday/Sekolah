<?php
namespace App\Repositories;

use App\Models\Submission;
use App\Interfaces\SubmissionInterface;

class SubmissionRepository implements SubmissionInterface
{
    public function create(array $data)
    {
        return Submission::create($data);
    }

    public function update(int $id, array $data)
    {
        $submission = Submission::where('task_id', $id)->firstOrFail();
    
        $submission->update($data);

        return $submission;
    }
    public function approve(int $id, array $data)
    {
        $submission = Submission::find($id);
        if ($submission) {
            $submission->update($data);
            return $submission;
        }
        return null;
    }
        public function getByTaskId($id)
    {
        
        return Submission::where('task_id', $id)
        ->get();
    }
}