<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Interfaces\ClassAccessInterface;

class ClassAccessRepository implements ClassAccessInterface
{
    public function isTeacher(
        int $teacherId,
        int $classId
    ) {
        return DB::table('class_teacher')
            ->where('teacher_id', $teacherId)
            ->where('class_id', $classId)
            ->exists();
    }

    public function isStudent(
        int $userId,
        int $classId
    ) {
        return DB::table('class_student')
            ->where('user_id', $userId)
            ->where('class_id', $classId)
            ->exists();
    }

    public function getClassTeacher(
        int $teacherId,
        int $classId
    ) {
        return DB::table('class_teacher')
            ->where('teacher_id', $teacherId)
            ->where('class_id', $classId)
            ->first();
    }
}