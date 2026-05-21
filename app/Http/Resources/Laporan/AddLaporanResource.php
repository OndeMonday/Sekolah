<?php

namespace App\Http\Resources\Laporan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddLaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_laporan'=>$this->id,
            'terlapor'=>$this->terlapor,
            'pelanggaran'=>$this->pelanggaran_id,
            'keterangan'=>$this->keterangan,    
            'bukti'=>$this->bukti,              
        ];
    }
}
