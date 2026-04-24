<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;

class AuthService
{
    protected UserInterface $userRepo;
    protected int $tokenLifetimeMinutes = 60;

    public function __construct(UserInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

public function register(array $data)
{
    $data['password'] = Hash::make($data['password']);

    return $this->userRepo->create($data);
}

    public function login(array $data)
    {
        $user = $this->userRepo->findBynisn_nip($data['nisn_nip']);

        $token = $user->createToken('api_token')->plainTextToken;

        $user->tokens()->latest()->first()->update([
            'expires_at' => Carbon::now()
                ->addMinutes($this->tokenLifetimeMinutes)
        ]);

        Cache::put(
            'user_'.$user->id,
            $user,
            now()->addMinutes($this->tokenLifetimeMinutes)
        );

        return [
            'token' => $token,
            'expires_in' => $this->tokenLifetimeMinutes * 60,
            'user' => $user
        ];
    }

    public function logout(?User $user): void
    {
        if (!$user) {
            return;
        }

        $user->tokens()->delete();

        Cache::forget('user_'.$user->id);
    }
}