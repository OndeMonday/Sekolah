<?php

namespace App\Interfaces;

interface UserInterface
{
    public function resetPassword(string $id, string $password);

    public function studentsByClass(string $classId);

    public function updateRole(string $id, string $role);

    public function create(array $data);

    public function findBynisn_nip(string $data);

    public function TeacherStudentByclass(string $name,string $teacher);

    
}