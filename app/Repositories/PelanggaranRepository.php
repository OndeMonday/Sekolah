<?php

namespace App\Repositories;

use App\Models\Pelanggaran;
use App\Interfaces\PelanggaranInterface;

class PelanggaranRepository implements PelanggaranInterface
{
       protected Pelanggaran $model;

    public function __construct(Pelanggaran $model)
    {
        $this->model = $model;
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id,array $data)
    {
  $pelanggaran =$this->model->where('id',$id)->firstOrFail();
  $pelanggaran->update($data);
  return $pelanggaran; 
    }

    public function delete(string $id)
    {
$pelanggaran=$this->model->where('id',$id)->firstOrFail();
$pelanggaran->delete();
return null;
    }

    public function get()
    {
        return $this->model->all();
    }
    public function satu(string $id)
    {
        return $this->model->where('id',$id)->firstOrFail();
    }

}