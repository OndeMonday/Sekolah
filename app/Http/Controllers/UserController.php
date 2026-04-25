<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Handlers\UserHandler;
use App\Http\Requests\ChangeRoleRequest;
use App\Http\Requests\ResetPasswordRequest;

class UserController extends Controller
{
    protected UserHandler $userHandler;

    public function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;
    }


    public function resetPassword(ResetPasswordRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $user = $this->userHandler->resetPassword($id, $data['password']);

            if (!$user) {
                return notFound('User tidak ditemukan');
            }

            return ok($user, 'Password reset successfully');

        } catch (\Exception $e) {
            return serverError('Gagal reset password', $e->getMessage());
        }
    }

    public function updateRole(ChangeRoleRequest $request, string $id)
    {
        try {
            $user = $this->userHandler->updateRole($id, $request->validated()['role']);

            if (!$user) {
                return notFound('User tidak ditemukan');
            }

            return ok($user, 'Role updated');

        } catch (\Exception $e) {
            return serverError($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $user = $this->userHandler->create($request->all());

            return created($user, 'User created');

        } catch (\Exception $e) {
            return serverError($e->getMessage());
        }
    }

    public function studentsByClass(string $classId)
    {
        try {
            $students = $this->userHandler->studentsByClass($classId);

            return ok($students, 'Berhasil mengambil data siswa');

        } catch (\Exception $e) {
            return serverError($e->getMessage());
        }
    }

    public function TeacherStudentByClass(string $name)
    {
        try {
            $teacher = auth()->user()?->nisn_nip;

            if (!$teacher) {
                return fail('Unauthorized', 401);
            }

            $data = $this->userHandler->TeacherStudentByClass($name, $teacher);

            return ok($data, 'Success');

        } catch (\Exception $e) {
            return serverError('Terjadi kesalahan server', $e->getMessage());
        }
    }
}