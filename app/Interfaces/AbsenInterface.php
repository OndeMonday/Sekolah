<?php

namespace App\Interfaces;

interface AbsenInterface
{
    public function all();

    public function findByUser(array $userId);
}