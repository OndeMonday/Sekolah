<?php

namespace App\Interfaces;

interface AkunInterface
{
    public function findById(int $id);

    public function updateRole(int $id, string $role);

    public function updatePassword(int $id, string $hashedPassword);

    public function getAll();

    public function getUsersByClass(int $classId);
}