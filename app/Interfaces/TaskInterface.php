<?php

namespace App\Interfaces;


use App\Models\Task;


interface TaskInterface
{
    public function deletetask(int $id);

    public function create(array $data);

    public function getForStudent(string $studentId);

    public function getTasksByTeacher(string $teacherId);

    public function getClassTeacherId(string $guruId, string $kelasId);

    public function getTaskByTeacherAndTaskId(string $teacherId, string $name);

    public function findById(int $id);

    public function update(Task $task, array $data);

}   