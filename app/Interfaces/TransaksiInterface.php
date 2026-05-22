<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface TransaksiInterface
{
    public function get();

    public function detail(string $id);

    public function create(array $data);

    public function callback(Request $request);
}