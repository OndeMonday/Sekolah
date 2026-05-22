<?php

namespace App\Interfaces;

interface MenuInterface
{
    public function get();

    public function detail(string $id);

    public function create(array $data);

    public function update(
        array $data,
        string $id
    );

    public function delete(string $id);

    public function tambah(string $menuid, int $stok);
}