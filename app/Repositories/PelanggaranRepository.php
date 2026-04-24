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
}