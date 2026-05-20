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
    public function gantinama(string $url,array $name)
    {
        return $this->repo->update($url,$name);
    }

    public function daftarkelas()
    {
        return $this->repo->all();
    }

    public function buatkelas(array $data)
    {
        return $this->repo->create($data);
    }
    public function hapuskelas(string $name)
    {
        return $this->repo->delete($name);
    }

    public function assignStudents(string $kelas, array $siswa)
    {
        return $this->repo->assignStudents($kelas, $siswa);
    }

public function assignTeachers(string $kelas, array $teachers): array
{
    $kelas = strtoupper(trim($kelas));

    $teachers = isset($teachers['nisn_nip'])
        ? [$teachers]
        : $teachers;

    $waliBaru = collect($teachers)
        ->firstWhere('walikelas', true);

    $waliBaruId = $waliBaru['nisn_nip'] ?? null;

    if ($waliBaruId) {
        $this->repo->resetWaliKelas($kelas);
    }

    $result = [];

    foreach ($teachers as $t) {
        $result[] = $this->repo->attachTeacher([
            'kelas' => $kelas,
            'nisn_nip' => $t['nisn_nip'],
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
    public function kelasajar(string $teacherId)
    {
        return $this->repo->kelasajar($teacherId);
}
public function removemurid(string $nisn)
{
    return $this->repo->removemurid($nisn);
}
}