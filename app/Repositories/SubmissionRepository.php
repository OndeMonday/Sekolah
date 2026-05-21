<?php

namespace App\Repositories;

use App\Models\Submission;
use App\Interfaces\SubmissionInterface;
use Illuminate\Support\Facades\DB;

class SubmissionRepository implements SubmissionInterface
{
    public function getAll(string $id)
    {
        return DB::table('tasks')
            ->join(
                'classes',
                'tasks.classes_class',
                '=',
                'classes.name'
            )
            ->join(
                'class_student',
                'classes.name',
                '=',
                'class_student.class_name'
            )
            ->join(
                'users as students',
                'class_student.student_nisn',
                '=',
                'students.nisn_nip'
            )
            ->join(
                'users as teachers',
                'tasks.teacher_nip',
                '=',
                'teachers.nisn_nip'
            )
            ->leftJoin('submissions', function ($join) use ($id) {
                $join->on(
                    'submissions.task_id',
                    '=',
                    'tasks.id'
                )->where(
                    'submissions.student_id',
                    '=',
                    $id
                );
            })
            ->where('students.nisn_nip', $id)
            ->select(
                'tasks.*',
                'teachers.name as teacher_name',
                'submissions.status as submission_status',
                'submissions.id as submission_id'
            )
            ->orderBy('tasks.created_at', 'desc')
            ->get();
    }

    public function create(array $data)
    {
        return Submission::create($data);
    }

    public function cektask(int $id)
    {
        return DB::table('Task')
            ->where('id', $id)
            ->firstOrFail();
    }

    public function update(
        string $TaskId,
        array $data,
        int $diri
    ) {
        $submission = Submission::where('task_id', $TaskId)
            ->where('student_id', $diri)
            ->first();

        if (!$submission) {
            return [
                'status' => false,
                'message' => 'Kamu belum punya submission untuk task ini',
                'data' => null
            ];
        }

        if ($submission->status === 'approved') {
            return [
                'status' => false,
                'message' => 'Tidak bisa update, sudah di-approve guru',
                'data' => null
            ];
        }

        $submission->update([
            'description' => $data['description']
                ?? $submission->description,

            'image_path' => $data['image_path']
                ?? $submission->image_path,
        ]);

        $submission->refresh();

        return $submission;
    }

    public function approve(string $id, array $data)
    {
        $submission = Submission::where('id', $id)
            ->firstOrFail();

        if ($submission) {
            $submission->update($data);

            return $submission;
        }

        return null;
    }

    public function getByTaskId(string $id)
    {
        return Submission::where('task_id', $id)
            ->get();
    }

    public function ceksub()
    {
        $studentId = auth()->user()->nisn_nip;

        $submission = DB::table('submissions')
            ->where('student_id', $studentId)
            ->paginate(5);

        return [
            'status' => (bool) $submission,

            'message' => $submission
                ? 'Sudah dikerjakan'
                : 'Belum dikerjakan',

            'data' => $submission
        ];
    }

    public function hapussub(
        int $TaskId,
        int $diri
    ) {
        $submission = Submission::where('task_id', $TaskId)
            ->where('student_id', $diri)
            ->firstOrFail();

        return $submission->delete();
    }

    public function taskbyid(
        string $TaskId,
        int $diri
    ) {
        return DB::table('submissions')
            ->join(
                'tasks',
                'submissions.task_id',
                '=',
                'tasks.id'
            )
            ->join(
                'users',
                'submissions.student_id',
                '=',
                'users.nisn_nip'
            )
            ->where('submissions.task_id', $TaskId)
            ->where('submissions.student_id', $diri)
            ->select(
                'submissions.*',
                'tasks.title as task_title',
                'users.name as student_name'
            )
            ->first();
    }
}