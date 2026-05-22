<?php

namespace App\Interfaces;

interface DetailTransaksiInterface
{
    public function get();

    public function detail(string $id);

    public function create(array $data);

    public function update(
        array $data,
        string $id
    );

    public function delete(string $id);
}