<?php
namespace App\Handlers;

use App\Interfaces\PelanggaranInterface;


class PelanggaranHandler
{
    protected PelanggaranInterface $repo;

    public function __construct(PelanggaranInterface $repo)
    {
        $this->repo = $repo;
    }
    public function addpelanggaran(array $data)
    {
        return $this->repo->create($data);
    }

    public function hapuspelanggaran(string $id)
    {
        return $this->repo->delete($id);
    }

    public function lihatpelanggaran()
    {
        return $this->repo->get();
    }
    public function editpelanggaran(string $id,array $isi)
    {
        return $this->repo->update($id,$isi);
    }
    public function satupelanggaran(string $id)
    {
        return $this->repo->satu($id);
    }


}