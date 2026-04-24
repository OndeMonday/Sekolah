<?php
namespace App\Repositories;

use App\Interfaces\PelanggaranInterface;
use App\Models\TipePelanggaran; 

class PelanggaranRepository implements PelanggaranInterface

{
    public function tipepelanggaran(array $data): TipePelanggaran
    {
        return TipePelanggaran::create($data);
    }
    public function listpelanggaran()
    {
        return TipePelanggaran::all();
    }
    public function updatepelanggaran(string $id, array $data)
    {
        $pelanggaran = TipePelanggaran::where('id', $id)->firstOrFail();
    
        $pelanggaran->update($data);

        return $pelanggaran;
    }
    public function deletepelanggaran(string $id)
    {
        $pelanggaran = TipePelanggaran::where('id', $id)->firstOrFail();
    
        $pelanggaran->delete();

        return null;
    }
}