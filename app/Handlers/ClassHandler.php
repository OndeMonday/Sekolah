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
}