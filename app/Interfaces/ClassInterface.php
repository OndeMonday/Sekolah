<?php

namespace App\Interfaces;

interface ClassInterface
{
    public function all();

    public function create(array $data);

    public function delete(string $id);

    public function update(string $name,array $id);

    public function nama(int $id, string $nama);

    public function assignStudents(string $kelas, array $siswa);

    public function resetWaliKelas(string $className);

    public function attachTeacher(array $data);

    public function getUsersByClass(string $className);
}