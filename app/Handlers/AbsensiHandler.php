<?php

namespace App\Handlers;

use App\Interfaces\AbsensiInterface;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Repositories\TelegramRepository;

class AbsensiHandler
{
    protected AbsensiInterface $interface;
    protected TelegramRepository $telegramRepo;

    public function __construct(
        AbsensiInterface $interface,
        TelegramRepository $telegramRepo) {
        $this->interface = $interface;
        $this->telegramRepo = $telegramRepo;
    }

public function store(Request $request)
{
    $user = auth()->user();
    $nisn = $user->nisn_nip;
    $today = now()->toDateString();
    $status = $request->status_absen;

    if (! $status) {
        return [
            'success' => false,
            'message' => 'Status absensi tidak boleh kosong'
        ];
    }

    // cek sudah absen
    $sudahAbsen = Absensi::where('user_id', $nisn)
        ->where('status', $status)
        ->whereDate('created_at', $today)
        ->exists();

    if ($sudahAbsen) {
        return [
            'success' => false,
            'message' => 'Anda sudah absen ' . $status
        ];
    }

    // cek pulang harus sudah masuk
    if ($status === 'pulang') {
        $sudahMasuk = Absensi::where('user_id', $nisn)
            ->where('status', 'masuk')
            ->whereDate('created_at', $today)
            ->exists();

        if (! $sudahMasuk) {
            return [
                'success' => false,
                'message' => 'Anda belum absen masuk'
            ];
        }
    }

    // upload foto (aman)
    $foto = null;
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto')->store('absensi', 'public');
    }

    // simpan data
    $data = [
        'user_id' => $nisn,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status' => $status,
        'foto' => $foto,
    ];

    $absen = $this->interface->store($data);

    // ambil telegram
    $telegram = $this->telegramRepo->getByNisn($nisn);

    // kirim notif
    if ($telegram && $telegram->chat_id) {

        $message =
    "*ABSENSI SISWA*\n\n"
    . " Nama      : {$user->name}\n"
    . " NISN      : {$nisn}\n"
    . " Status    : " . strtoupper($status) . "\n"
    . " Waktu     : " . now()->format('d-m-Y H:i:s') . "\n"
    . " Lokasi    : {$request->latitude}, {$request->longitude}\n\n"
    . "---------------------------------------------------------";
        $this->telegramRepo->sendMessage(
            $telegram->chat_id,
            $message
        );
    }

    return [
        'success' => true,
        'message' => 'Berhasil absen',
        'data' => $absen
    ];
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