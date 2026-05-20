<?php
namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TaskInterface;

class TaskRepository implements TaskInterface
{

public function findById(string $TaskId): ?Task
{
    return Task::where('id', $TaskId)->firstOrFail();
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

        ->join('users as students', 'class_student.student_nisn', '=', 'students.nisn_nip')

        ->join('users as teachers', 'tasks.teacher_nip', '=', 'teachers.nisn_nip')

        ->where('students.nisn_nip', $studentId)

        ->select(
            'tasks.*',
            'teachers.name as teacher_name' 
        )

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

public function getMapelGuru(string $guru, string $name): ?string
    {
        return DB::table('class_teacher')
            ->where('teacher_nip', $guru)
            ->where('classes_class', $name)
            ->value('mapel');
    }

    public function getClassTeacherId(string $guru, string $name): ?string
    {
        return DB::table('class_teacher')
            ->where('teacher_nip', $guru)
            ->where('classes_class', $name)
            ->value('teacher_nip');
    }
public function getTaskByTeacherAndTaskId(string $teacher, string $name)
{
    return Task::where('teacher_nip', $teacher)
    ->where('classes_class', $name)
    ->withCount('submissions as done_count')
    ->orderBy('created_at', 'desc')
    ->paginate(4);
}
}