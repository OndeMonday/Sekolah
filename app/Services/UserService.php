<?php

namespace App\Services;

use App\Repositories\AkunRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected AkunRepository $akunRepo;

    public function __construct(AkunRepository $akunRepo)
    {
        $this->akunRepo = $akunRepo;
    }
    public function getUsersByClass(int $classId)
{
    return $this->akunRepo->getUsersByClass($classId);
}

}