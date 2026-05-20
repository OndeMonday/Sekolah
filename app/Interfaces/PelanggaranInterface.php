<?php

namespace App\Interfaces;

interface PelanggaranInterface
{
    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);

    public function get();

    public function satu(string $id);
}