<?php

namespace App\Repositories;

use App\Models\Laporan;
use App\Interfaces\LaporanInterface;
use App\Models\Pelanggaran;
use Override;

use function Laravel\Prompts\select;

class LaporanRepository implements LaporanInterface
{
    protected Laporan $model;

    public function __construct(Laporan $model)
    {
        $this->model = $model;
    }

    public function create(array $data,string $pelapor)
    {
        $data['pelapor'] = $pelapor;
        return $this->model->create($data);
    }

    public function update(string $id,array $laporanData )
     {
        $laporan = $this->model
            ->where('laporan.id', $id)
            ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')
            ->select('laporan.*', 'pelanggaran.*')
            ->firstOrFail();

        $laporan->update($laporanData);

        return $laporan;
    }

    public function delete(string $id)
    {
        $laporan = $this->model
            ->where('id', $id)
            ->firstOrFail();

        $laporan->delete();

        return null;
    }

    public function get()
    {
        $diri = auth()->user()->nisn_nip;
        $hasil= $this->model
        ->where('pelapor',$diri)
        ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')
        ->select('laporan.*', 'pelanggaran.*')
        ->paginate(10);
        return $hasil;
    }

public function satu(string $laporanid)
{
    return $this->model
        ->where('laporan.id', $laporanid)
        ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')
        ->join('users', 'laporan.pelapor', '=', 'users.nisn_nip')
        ->select(
            'laporan.*',
            'users.*',
            'pelanggaran.*'
        )
        ->first();
}

public function laporanorang(
    string $userid,
    ?string $search = null,
)
{
    $query = $this->model
        ->where('laporan.terlapor', $userid)
        ->join('users', 'laporan.pelapor', '=', 'users.nisn_nip')
        ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')

        ->when($search, function ($q) use ($search) {
            $q->where('pelanggaran.name', 'like', "%{$search}%");
        })

        ->select(
            'users.name as pelapor',
            'laporan.*',
            'pelanggaran.*'
        );

    $data = $query->paginate(10);

    $totalPoin = $this->model
        ->where('laporan.terlapor', $userid)
        ->where('laporan.status', 'diterima')
        ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')
        ->sum('pelanggaran.poin');

    return [
        'data' => $data,
        'total_poin' => $totalPoin
    ];
}
    public function jenislaporan(string $pelanggaranid,?string $search = null)
{
    return $this->model
        ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')
        ->join('users', 'laporan.pelapor', '=', 'users.nisn_nip')

        ->where('laporan.pelanggaran_id', $pelanggaranid)

        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%");
            });
        })

        ->select(
            'users.name as pelapor',
            'laporan.*',
            'pelanggaran.*'
        )

        ->paginate(10);
}
    public function active(string $data)
    {
        return Pelanggaran::where('id',$data)
        ->where('active',true)
        ->first();
    }
public function laporansemua(?string $search = null)
{
    $query = $this->model
        ->join('users', 'laporan.pelapor', '=', 'users.nisn_nip')
        ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')

        ->when($search, function ($q) use ($search) {
            $q->where(function ($inner) use ($search) {
                $inner->where('users.name', 'like', "%{$search}%")
                      ->orWhere('pelanggaran.name', 'like', "%{$search}%")
                      ->orWhere('pelanggaran.poin', 'like', "%{$search}%");
            });
        })

        ->when(request('pelapor'), fn($q) =>
            $q->where('users.nisn_nip', request('pelapor'))
        )
        ->when(request('terlapor'), fn($q) =>
            $q->where('laporan.terlapor', request('terlapor'))
        )

        ->when(request('pelanggaran_id'), fn($q) =>
            $q->where('pelanggaran.id', request('pelanggaran_id'))
        )

        ->when(request('min'), fn($q) =>
            $q->where('pelanggaran.poin', '>=', request('min'))
        )

        ->when(request('max'), fn($q) =>
            $q->where('pelanggaran.poin', '<=', request('max'))
        )

        ->when(request('dari'), fn($q) =>
            $q->whereDate('laporan.created_at', '>=', request('dari'))
        )

        ->when(request('sampai'), fn($q) =>
            $q->whereDate('laporan.created_at', '<=', request('sampai'))
        );

    $sortBy = request('kolom');
    $sortDir = request('mulai', 'desc');

    $allowedSort = [
        'created_at' => 'laporan.created_at',
        'poin'       => 'pelanggaran.poin',
    ];

    if (isset($allowedSort[$sortBy])) {
        $query->orderBy(
            $allowedSort[$sortBy],
            in_array($sortDir, ['asc', 'desc']) ? $sortDir : 'desc'
        );
    } else {
        $query->orderBy('laporan.created_at', 'desc');
    }

    return $query->select(
        'users.name as pelapor',
        'laporan.*',
        'pelanggaran.*'
    )->paginate(10);
}
public function pelanggaransaya(string $userid)
{
    $query = $this->model
        ->join('pelanggaran', 'laporan.pelanggaran_id', '=', 'pelanggaran.id')
        ->where('laporan.terlapor', $userid);

    $data = (clone $query)
        ->select(
            'laporan.*',
            'pelanggaran.poin',
            'pelanggaran.name'
        )
        ->paginate(10);

    $totalPoin = (clone $query)
        ->where('laporan.status', 'diterima')
        ->sum('pelanggaran.poin');

    $message = null;

    if ($totalPoin >= 100) {
        $message = 'SP3 (Pelanggaran Berat)';
    } elseif ($totalPoin >= 50) {
        $message = 'SP2 (Pelanggaran Sedang)';
    } elseif ($totalPoin >= 20) {
        $message = 'SP1 (Pelanggaran Ringan)';
    } else {
        $message = 'Aman';
    }

    return [
        'data' => $data,
        'total_poin' => $totalPoin,
        'message' => $message
    ];
}
public function nilai(string $laporanid, array $data)
{
    $laporan = $this->model
        ->where('id', $laporanid)
        ->firstOrFail();

    $laporan->update([
        'status' => $data['status']
    ]);

    return $laporan;
}
}