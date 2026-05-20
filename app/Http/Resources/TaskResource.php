<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'NIP' => $this->teacher_nip,
            'kelas' => $this->classes_class,
            'judul' => $this->title,
            'deskripsi' => $this->description,
            'image' => $this->image_path,
            'deadline' => $this->deadline,
            'mapel' => $this->mapel ?? null,
        ];
    }
}