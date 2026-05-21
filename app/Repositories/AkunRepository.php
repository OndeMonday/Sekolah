<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\AkunInterface;

class AkunRepository implements AkunInterface
{
    public function findById(int $id)
    {
        return User::findOrFail($id);
    }

    public function updateRole(
        int $id,
        string $role
    ) {
        $user = User::findOrFail($id);

        $user->update([
            'role' => $role
        ]);

        return $user;
    }

    public function updatePassword(
        int $id,
        string $hashedPassword
    ) {
        $user = User::findOrFail($id);

        $user->update([
            'password' => $hashedPassword
        ]);

        return $user;
    }

    public function getAll()
    {
        return User::all();
    }

    public function getUsersByClass(int $classId)
    {
        $teachers = User::join(
                'teacher_classes',
                'users.nisn_nip',
                '=',
                'teacher_classes.teacher_nip'
            )
            ->where(
                'teacher_classes.class_name',
                $classId
            )
            ->select('users.*')
            ->get();

        $students = User::join(
                'student_classes',
                'users.nisn_nip',
                '=',
                'student_classes.student_nisn'
            )
            ->where(
                'student_classes.class_name',
                $classId
            )
            ->select(
                'users.*',
                'student_classes.*'
            )
            ->get();

        return $teachers
            ->concat($students)
            ->sortBy([
                ['role', 'asc'],
                ['name', 'asc']
            ])
            ->values();
    }
}