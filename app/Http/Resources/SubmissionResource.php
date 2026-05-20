<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'NISN' => $this->student_id,
            'S_ID' => $this->id,
            'T_ID' => $this->task_id,
            'gambar' => $this->image_path,
            'deskripsi' => $this->description,
            'nilai'=>$this->nilai,
            'status' => $this->status,
            'diterima' => $this->approved_at,
            'dikirim' => $this->submitted_at,
            'catatan'=>$this->teacher_note,
            'diupdate'=>$this->updated_at
        ];
    }
}
