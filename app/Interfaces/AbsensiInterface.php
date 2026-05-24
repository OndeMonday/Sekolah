<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface AbsensiInterface
{
    public function store(array $data);
    public function myAbsensi(string $userId);
    public function index(Request $request);
        public function exportData(
        string $kelas,
        int $bulan,
        int $tahun
    );
    public function sudahAbsen(string $userId, string $statusAbsen);
    public function sudahMasuk(string $userId);
}