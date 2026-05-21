<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserHandler
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->create($data);
    }
}
