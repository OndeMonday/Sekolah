<?php

namespace App\Repositories;

use App\Interfaces\AbsenInterface;
use App\Models\Absen;

class AbsenRepository implements AbsenInterface
{
    protected Absen $model;

    public function __construct(Absen $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model
            ->with('user')
            ->latest()
            ->get();
    }

    public function findByUser(array $userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }
}