<?php

namespace App\Interfaces;

interface ClassAccessInterface
{
    public function isTeacher(int $teacherId, int $classId);

    public function isStudent(int $userId, int $classId);

    public function getClassTeacher(int $teacherId, int $classId);
}