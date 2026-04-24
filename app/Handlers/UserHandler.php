<?php

namespace App\Handlers;

use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserHandler
{
    protected UserInterface $userRepo;

    public function __construct(UserInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function resetPassword(string $userId, string $password)
    {
        return $this->userRepo->resetPassword($userId, $password);
    }

    public function studentsByClass(string $classId)
    {
        return $this->userRepo->studentsByClass($classId);
    }

    public function updateRole(string $userId, string $role)
    {
        return $this->userRepo->updateRole($userId, $role);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->create($data);
    }

    public function findByNisnNip(string $nisn_nip)
    {
        return $this->userRepo->findBynisn_nip($nisn_nip);
    }
    public function TeacherStudentByClass(string $Id,string $teacher)
    {
        return $this->userRepo->TeacherStudentByClass($Id,$teacher);
    }
}
