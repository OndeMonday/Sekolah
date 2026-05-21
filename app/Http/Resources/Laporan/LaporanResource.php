<?php

namespace App\Http\Resources\Laporan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'terlapor'=>$this->terlapor,
            'keterangan'=>$this->keterangan,     
            'poin'=>$this->poin    
        ];
    }
}
