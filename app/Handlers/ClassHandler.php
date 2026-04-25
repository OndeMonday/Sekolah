<?php
namespace App\Handlers;

use App\Repositories\ClassRepository;


class ClassHandler
{
    protected ClassRepository $repo;

    public function __construct(ClassRepository $repo)
    {
        $this->repo = $repo;
    }
    public function gantinama(string $name,array $id)
    {
        return $this->repo->update($name,$id);
    }

    public function daftarkelas()
    {
        return $this->repo->all();
    }

    public function buatkelas(array $data)
    {
        return $this->repo->create($data);
    }
    public function hapuskelas(string $id)
    {
        return $this->repo->delete($id);
    }

    public function assignStudents(string $kelas, array $siswa)
    {
        return $this->repo->assignStudents($kelas, $siswa);
    }

public function assignTeachers(string $kelas, array $teachers): array
{
    $kelas = strtoupper(trim($kelas));

    $teachers = isset($teachers['user_id']) ? [$teachers] : $teachers;

    $waliBaruId = collect($teachers)
        ->firstWhere('walikelas', true)['user_id'] ?? null;

    if ($waliBaruId) {
        $this->repo->resetWaliKelas($kelas);
    }

    $result = [];

    foreach ($teachers as $t) {

        $result[] = $this->repo->attachTeacher([
            'kelas' => $kelas,
            'user_id' => $t['user_id'],
            'mapel' => $t['mapel'] ?? null,
            'walikelas' => $t['walikelas'] ?? false,
        ]);
    }

    return $result;
}
    public function getUsersByClass(string $kelas)
    {
        return $this->repo->getUsersByClass($kelas);
    }
}