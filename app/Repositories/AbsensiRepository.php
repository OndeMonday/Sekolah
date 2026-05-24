<?php

namespace App\Repositories;

use App\Interfaces\AbsensiInterface;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AbsensiRepository implements AbsensiInterface
{
    protected Absensi $model;

    public function __construct(Absensi $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function myAbsensi(string $userId)
{
    return $this->model
        ->where('user_id', $userId)
        ->latest()
        ->get();
}

public function index(Request $request)
{
    $query = $this->model
        ->join(
            'users',
            'users.nisn_nip',
            '=',
            'absensis.user_id'
        )
        ->leftJoin(
            'class_student',
            'class_student.student_nisn',
            '=',
            'users.nisn_nip'
        )
        ->select(
            'absensis.*',
            'users.name',
            'users.nisn_nip',
            'class_student.class_name'
        )
        ->distinct();

    // filter kelas
    if ($request->filled('kelas')) {

        $query->where(
            'class_student.class_name',
            $request->kelas
        );
    }

    // filter status
    if ($request->filled('status')) {

        $query->where(
            'absensis.status',
            $request->status
        );
    }

    // filter nisn
    if ($request->filled('nisn_nip')) {

        $query->where(
            'users.nisn_nip',
            'like',
            '%'.$request->nisn_nip.'%'
        );
    }

    // filter nama
    if ($request->filled('name')) {

        $query->where(
            'users.name',
            'like',
            '%'.$request->name.'%'
        );
    }

    // filter tanggal
    if ($request->filled('tanggal')) {

        $query->whereDate(
            'absensis.created_at',
            $request->tanggal
        );
    }

    // whitelist sorting
    $allowedSort = [
        'created_at',
        'status',
        'name',
        'class_name'
    ];

    $sortBy = in_array(
        $request->get('sort_by'),
        $allowedSort
    )
    ? $request->get('sort_by')
    : 'created_at';

    // sorting direction
    $sortDirection = strtolower(
        $request->get('sort_direction', 'desc')
    );

    if (! in_array($sortDirection, ['asc', 'desc'])) {

        $sortDirection = 'desc';
    }

    return $query
        ->orderBy($sortBy, $sortDirection)
        ->paginate(
            $request->get('per_page', 10)
        );
}
public function exportData(
        string $kelas,
        int $bulan,
        int $tahun
    ) {
        return $this->model
            ->join(
                'users',
                'users.nisn_nip',
                '=',
                'absensis.user_id'
            )
            ->join(
                'class_student',
                'class_student.student_nisn',
                '=',
                'users.nisn_nip'
            )
            ->where(
                'class_student.class_name',
                $kelas
            )
            ->where(
                'absensis.status',
                'masuk'
            )
            ->whereMonth(
                'absensis.created_at',
                $bulan
            )
            ->whereYear(
                'absensis.created_at',
                $tahun
            )
            ->select(
                'users.name',
                'users.nisn_nip',
                'class_student.class_name',
                'absensis.created_at'
            )
            ->orderBy('users.name')
            ->get();
    }
       public function sudahAbsen(string $userId, string $status)
    {
        return DB::table('absensis')
            ->where('user_id', $userId)
            ->where('status', $status)
            ->whereDate('created_at', today())
            ->exists();
    }

    public function sudahMasuk(string $userId)
    {
        return DB::table('absensis')
            ->where('user_id', $userId)
            ->where('status', 'masuk')
            ->whereDate('created_at', today())
            ->exists();
    }

public function storeAbsensi(Request $request, string $nisn)
{
    $path = $request->file('foto')->store('absensi', 'public');

    return DB::table('absensis')->insertGetId([
        'user_nisn' => $nisn,
        'foto' => $path,
        'status' => $request->status_absen,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
}