<?php

namespace App\Interfaces;

interface PelanggaranInterface

{
    public function listpelanggaran();
    public function tipepelanggaran(array $data);
    public function updatepelanggaran(string $id,array $data);
}