<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Handlers\AuthHandler;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    protected AuthHandler $authHandler;

    public function __construct(AuthHandler $authHandler)
    {
        $this->authHandler = $authHandler;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $this->authHandler->register($request->validated());

            return created($data, 'Registrasi berhasil');

        } catch (Throwable $e) {
            return serverError('Gagal melakukan registrasi', $e->getMessage());
        }
    }


    public function login(LoginRequest $request)
    {
        try {
            $data = $this->authHandler->login($request->validated());

            return ok($data, 'Login berhasil');

        } catch (Throwable $e) {
            return serverError('Cek dan coba lagi', $e->getMessage());
        }
    }


    public function logout(Request $request)
    {
        try {
            $this->authHandler->logout($request->user());

            return ok(null, 'Logout berhasil');

        } catch (Throwable $e) {
            return serverError('Logout gagal', $e->getMessage());
        }
    }


    public function me(Request $request)
    {
        try {
            $user = $request->user();

            return ok([
                'id'   => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ], 'Berhasil mengambil data user');

        } catch (Throwable $e) {
            return serverError('Gagal mengambil data user', $e->getMessage());
        }
    }
}