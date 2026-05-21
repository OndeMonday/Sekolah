<?php

namespace App\Http\Resources\Laporan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminLaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lapor'=>$this->pelapor,
            'dilaporkan'=>$this->terlapor,
            'jenis_pelanggaran'=>$this->name,
            'bukti'=>$this->bukti,
            'keterangan'=>$this->keterangan,           
            'poin'=>$this->poin

        ];
    }
}
