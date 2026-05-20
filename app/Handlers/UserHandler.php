<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserHandler
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function resetPassword(string $id, string $password)
    {
        return $this->userRepo->resetPassword($id, $password);
    }

    public function studentsByClass(string $classId)
    {
        return $this->userRepo->studentsByClass($classId);
    }

    public function updateRole(string $id, string $role)
    {
        return $this->userRepo->updateRole($id, $role);
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
    public function TeacherStudentByClass(string $name,string $teacher)
    {
        return $this->userRepo->TeacherStudentByClass($name,$teacher);
    }
    public function murid():array
    {
        return $this->userRepo->murid();
    }
    public function muridall()
    {
        return $this->userRepo->muridall();
    }
}
