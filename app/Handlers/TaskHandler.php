<?php
namespace App\Handlers;

use App\Repositories\TaskRepository;


class TaskHandler
{
    protected TaskRepository $repo;

    public function __construct(TaskRepository $repo)
    {
        $this->repo = $repo;
    }

 public function store($guru, $request): array
{
    $classId = $request->class_id;

    if (empty($classId)) {
        return ['error' => 'Kelas Harus Diisi'];
    }

    if ($request->hasFile('image_path')) {
        $path = $request->file('image_path')->store('tasks', 'public');
    } else {
        $path = null;
    }

    $classTeacherId = $this->repo->getClassTeacherId($guru->nisn_nip, $classId);
    if (!$classTeacherId) {
        return ['error' => 'Tidak Mengajar Kelas Tersebut'];
    }

    $mapel = $this->repo->getMapelGuru($guru->nisn_nip, $classId);

    $task = $this->repo->create([
        'teacher_nip' => $classTeacherId,
        'classes_class' => $classId,
        'title' => $request->title,
        'description' => $request->description ?? null,
        'image_path' => $path,
        'deadline' => $request->deadline,
    ]);

    $result = $task->toArray(); 
    $result['mapel'] = $mapel;

    return $result;
}
    public function tasksForStudent(string $studentId)
    {
        return $this->repo->getForStudent($studentId);
    }

    public function myTasks(string $teacherId)
    {
        return $this->repo->getTasksByTeacher($teacherId);
    }
public function getTaskByTeacherAndTaskId($teacherId,string $name)
{
    $task = $this->repo->getTaskByTeacherAndTaskId($teacherId->nisn_nip, $name);

    if ($task->isEmpty()) {
        return ['error' => 'Tidak ada tugas di kelas ini'];
    }

    return $task;
}
public function deletetask(int $id)
{
    return $this->repo->deletetask($id);
}
public function updateTask($guru, int $id, $request): array
{
    $task = $this->repo->findById($id);

    if (!$task) {
        return ['error' => 'Tugas tidak ditemukan'];
    }

    if ($task->teacher_nip !== $guru->nisn_nip) {
        return ['error' => 'Unauthorized'];
    }

    $path = $task->image_path;

    if ($request->hasFile('image_path')) {
        $path = $request->file('image_path')->store('tasks', 'public');
    }

    $data = [
        'title' => $request->title,
        'description' => $request->description ?? null,
        'image_path' => $path,
        'deadline' => $request->deadline,
    ];

    return $this->repo->update($task, $data)->toArray();
}
}