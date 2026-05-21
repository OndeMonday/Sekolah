<?php

namespace App\Handlers;

use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class AuthHandler
{
    protected UserInterface $userRepo;

    public function __construct(UserInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data): User
    {
        
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->create($data);
    }

public function login(array $data)
{
    $user = $this->userRepo->findBynisn_nip($data['nisn_nip']);

    if (!$user || !Hash::check($data['password'], $user->password)) {
        throw new \Exception('Password Salah');
    }

    $tokenResult = $user->createToken('api_token');

    $expiresAt = now()->addMinutes(99999);

    $tokenResult->accessToken->expires_at = $expiresAt;
    $tokenResult->accessToken->save();

    return [
        'token' => $tokenResult->plainTextToken,
        'user' => $user,
        'expires_at' => $expiresAt
    ];
}

    public function logout(?User $user): void
    {
        if (!$user) return;

        $user->tokens()->delete();
        Cache::forget('user_'.$user->id);
    }
}