<?php
namespace App\Handlers;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;


class TaskHandler
{
    protected TaskRepository $repo;

    public function __construct(TaskRepository $repo)
    {
        $this->repo = $repo;
    }

public function store( $guru, string $name, $request)
{
    $path = $request->file('image')
        ? $request->file('image')->store('tasks', 'public')
        : null;

    $classTeacherId = $this->repo->getClassTeacherId($guru->nisn_nip, $name);

    if (!$classTeacherId) {
        return [
            'success' => false,
            'message' => 'Tidak Mengajar Kelas Tersebut'
        ];
    }

    $mapel = $this->repo->getMapelGuru($guru->nisn_nip, $name);

    $task = $this->repo->create([
        'teacher_nip' => $classTeacherId,
        'classes_class' => $name,
        'title' => $request->title,
        'description' => $request->description ?? null,
        'image_path' => $path,
        'deadline' => $request->deadline,
    ]);

    $task->mapel = $mapel;

return $task;   
}
    public function tasksForStudent(string $studentId)
    {
        return $this->repo->getForStudent($studentId);
    }

    public function myTasks(string $teacherId)
    {
        return $this->repo->getTasksByTeacher($teacherId);
    }
public function getTaskByTeacherAndTaskId($teacher,string $name)
{
    $task = $this->repo->getTaskByTeacherAndTaskId($teacher->nisn_nip, $name);

    if ($task->isEmpty()) {
        return ['error' => 'Tidak ada tugas di kelas ini'];
    }

    return $task;
}
public function deletetask(int $id)
{
    return $this->repo->deletetask($id);
}
public function updateTask($guru, int $id, Request $request): array
{
    $task = $this->repo->findById($id);

    if (!$task) {
        return ['error' => 'Tugas tidak ditemukan'];
    }

    if ($task->teacher_nip !== $guru->nisn_nip) {
        return ['error' => 'Unauthorized'];
    }

    $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'deadline' => 'required|date',
        'image_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $path = $task->image_path;

    if ($request->hasFile('image_path')) {
        $path = $request->file('image_path')->store('tasks', 'public');
    }

    $data = [
        'title' => $request->input('title', $task->title),
        'description' => $request->input('description', $task->description),
        'image_path' => $path,
        'deadline' => $request->input('deadline', $task->deadline),
    ];

    return $this->repo->update($task, $data)->toArray();
}
}