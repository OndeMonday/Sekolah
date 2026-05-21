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
}