<?php

namespace App\Interfaces;

interface UserInterface
{
    public function resetPassword(string $userId, string $password);

    public function studentsByClass(string $classId);

    public function updateRole(string $userId, string $role);

    public function create(array $data);

    public function findBynisn_nip(string $data);

    public function TeacherStudentByclass(string $Id,string $teacher);

    
}