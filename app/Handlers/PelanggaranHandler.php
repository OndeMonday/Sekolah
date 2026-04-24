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
    public function listpelanggaran()
    {
        return $this->repository->listpelanggaran();
    }
    public function updatepelanggaran(string $id, array $data)
    {
        return $this->repository->updatepelanggaran($id, $data);
    }
    public function deletepelanggaran(string $id)
    {
        return $this->repository->deletepelanggaran($id);
    }
}
