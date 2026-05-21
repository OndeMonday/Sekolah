<?php
namespace App\Handlers;

use App\Interfaces\LaporanInterface;
use App\Repositories\LaporanRepository;
use Exception;
use Illuminate\Http\Request;




class LaporanHandler
{
    protected LaporanInterface $interface;
    protected LaporanRepository $repo;

    public function __construct(LaporanInterface $interface , LaporanRepository $repo)
    {
        $this->interface = $interface;
        $this->repo=$repo;
    }
    
    public function addlaporan(array $data, Request $request)
    {
        $active =$this->repo->active($data['pelanggaran_id']);

        if (!$active){
             throw new Exception('Pelanggaran Tidak Aktif');}

        $path = $request->file('bukti')
        ? $request->file('bukti')->store('laporan', 'public')
        : null;
        $pelapor = auth()->user()->nisn_nip;

        $laporanData = [
            'pelapor' => $pelapor,
            'terlapor' => $data['terlapor'],
            'pelanggaran_id' => $data['pelanggaran_id'],
            'bukti' => $path,
            'keterangan' => $data['keterangan'] ?? null,
        ];
        return $this->interface->create($laporanData, $pelapor);
    }

    public function editlaporan(string $id,array $data, Request $request)
    {
        $path = $request->file('bukti')
        ? $request->file('bukti')->store('laporan', 'public')
        : null;
        $laporanData = [
            'terlapor' => $data['terlapor']?? null,
            'pelanggaran_id' => $data['pelanggaran_id']?? null,
            'bukti' => $path?? null,
            'keterangan' => $data['keterangan'] ?? null,
        ];
        return $this->interface->update($id, $laporanData);
    }

}