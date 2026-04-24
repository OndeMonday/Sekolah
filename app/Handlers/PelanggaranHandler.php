<?php

namespace App\Handlers;

use App\Repositories\PelanggaranRepository;

class PelanggaranHandler


{
    protected PelanggaranRepository $repository;

    public function __construct(PelanggaranRepository $repository)
    {
        $this->repository = $repository;
    }

    public function tipepelanggaran(array $data)
    {
        return $this->repository->tipepelanggaran($data);
    }
}
