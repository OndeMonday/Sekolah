<?php

namespace App\Handlers;

use App\Interfaces\AbsensiInterface;
use App\Models\Absensi;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiHandler
{
    protected AbsensiInterface $interface;

    public function __construct(
        AbsensiInterface $interface
    ) {
        $this->interface = $interface;
    }

    public function store(Request $request)
{
    $today = now()->toDateString();

    $data = [
        'user_id' => auth()->user()->nisn_nip,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status' => $request->status_absen,
    ];

    // cek sudah absen
    $sudahAbsen = Absensi::where(
        'user_id',
        $data['user_id']
    )
    ->where(
        'status',
        $data['status']
    )
    ->whereDate(
        'created_at',
        $today
    )
    ->exists();

    if ($sudahAbsen) {

        throw new Exception(
            'Anda sudah absen '.$data['status']
        );
    }

    // pulang harus sudah masuk
    if ($data['status'] === 'pulang') {

        $sudahMasuk = Absensi::where(
            'user_id',
            $data['user_id']
        )
        ->where(
            'status',
            'masuk'
        )
        ->whereDate(
            'created_at',
            $today
        )
        ->exists();

        if (! $sudahMasuk) {

            throw new Exception(
                'Anda belum absen masuk'
            );
        }
    }

    // upload foto setelah semua validasi lolos
    $foto = $request->file('foto')
        ->store('absensi', 'public');

    $data['foto'] = $foto;

    return $this->interface->store($data);
}
 public function exportPdf(Request $request)
    {
        $kelas = $request->kelas;

        $bulan = (int) $request->bulan;

        $tahun = (int) $request->tahun;

        $absensi = $this->interface->exportData(
            $kelas,
            $bulan,
            $tahun
        );

        // jumlah hari dalam bulan
        $jumlahHari = cal_days_in_month(
            CAL_GREGORIAN,
            $bulan,
            $tahun
        );

        // format data siswa
        $siswa = [];

        foreach ($absensi as $item) {

            $nisn = $item->nisn_nip;

            if (! isset($siswa[$nisn])) {

                $siswa[$nisn] = [
                    'name' => $item->name,
                    'nisn_nip' => $item->nisn_nip,
                    'class_name' => $item->class_name,
                    'hari' => []
                ];
            }

            $tanggal = date(
                'j',
                strtotime($item->created_at)
            );

            $siswa[$nisn]['hari'][$tanggal] = true;
        }

        $pdf = Pdf::loadView(
            'pdf.absensi',
            [
                'siswa' => $siswa,
                'jumlahHari' => $jumlahHari,
                'kelas' => $kelas,
                'bulan' => $bulan,
                'tahun' => $tahun
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            'absensi-'.$kelas.'-'.$bulan.'-'.$tahun.'.pdf'
        );
    }
}