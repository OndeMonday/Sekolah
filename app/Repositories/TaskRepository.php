<?php
namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TaskInterface;

class TaskRepository implements TaskInterface
{

public function findById(int $id): ?Task
{
    return Task::find($id);
}

public function update(Task $task, array $data): Task
{
    $task->update($data);
    return $task;
}
    public function create(array $data): Task
    {
        return Task::create($data);
    }

        public function deletetask(int $id)
    {
        $class = Task::where('id', $id)->firstOrFail();
        return $class->delete();
    }

public function getForStudent(string $studentId)
{
    return DB::table('tasks')
        ->join('classes', 'tasks.classes_class', '=', 'classes.name')
        ->join('class_student', 'classes.name', '=', 'class_student.class_name')
        ->join('users', 'class_student.student_nisn', '=', 'users.nisn_nip')
        ->where('users.nisn_nip', $studentId)
        ->select('tasks.*')
        ->orderBy('tasks.created_at', 'desc')
        ->paginate(5); 
}
public function  getTasksByTeacher(string $teacherId)
{
    $perPage = 4; 

    $teacherClassIds = DB::table('class_teacher')
        ->where('teacher_nip', $teacherId)
        ->pluck('classes_class');

    if ($teacherClassIds->isEmpty()) {
        return collect();
    }

    $tasks = Task::whereIn('classes_class', $teacherClassIds)
        ->paginate($perPage)
        ->orderBy('created_at', 'desc');
       
    return $tasks;
    
}

public function getMapelGuru(string $guru, string $classId): ?string
    {
        return DB::table('class_teacher')
            ->where('teacher_nip', $guru)
            ->where('classes_class', $classId)
            ->value('mapel');
    }

    public function getClassTeacherId(string $guru, string $classId): ?string
    {
        return DB::table('class_teacher')
            ->where('teacher_nip', $guru)
            ->where('classes_class', $classId)
            ->value('teacher_nip');
    }
public function getTaskByTeacherAndTaskId($teacherId, string $name)
{
    return Task::where('teacher_nip', $teacherId)
        ->where('classes_class', $name)
        ->orderBy('created_at', 'desc')
        ->get();
}
}