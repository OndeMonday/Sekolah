<?php
namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
        public function findBynisn_nip(string $data)
    {
        return User::where('nisn_nip', $data)->firstOrFail();
    }
            public function create(array $data)
    {
        return User::create($data);
    }




public function updateRole(string $id, string $role)
{
    $user = User::where('nisn_nip', $id)->firstOrFail();

    $user->update([
        'role' => $role
    ]);

    return $user;
}
        public function resetPassword(string $id, string $password)
    {
        $user = User::find($id);
        if ($user) {
            $user->password = bcrypt($password);
            $user->save();
            return $user;
        }
        return null;
    }

public function studentsByClass(string $classId)
{
 return DB::table('class_student')
 ->join('classes','classes.name','=','class_student.class_name')
 ->where('classes.name', $classId)
 ->select(
    'class_student.class_name','class_student.student_nisn'
 )->get();
 
}
public function TeacherStudentByClass(string $name, string $teacher)
{
    $isTeaching = DB::table('class_teacher')
        ->where('classes_class', $name)
        ->where('teacher_nip', $teacher)
        ->exists();

    if (!$isTeaching) {
        abort(403, 'Guru tidak mengajar kelas tersebut');
    }

$search = request()->get('search');

return DB::table('class_student')
    ->join('users', 'users.nisn_nip', '=', 'class_student.student_nisn')
    ->where('class_student.class_name', $name)
    ->when($search, function ($query, $search) {
        $query->where(function ($q) use ($search) {
            $q->where('users.name', 'LIKE', "%{$search}%")
              ->orWhereRaw("CAST(users.nisn_nip AS CHAR) LIKE ?", ["%{$search}%"]);
        });
    })
    ->select('users.name', 'users.nisn_nip', 'users.role')
    ->orderBy('users.name', 'asc')
    ->paginate(6);
}
public function murid(): array
{
    return [
        'murid' => User::where('role', 'murid')->count(),
        'guru' => User::where('role', 'guru')->count(),
        'kelas'=>DB::table('classes')->select('name')->count()
    ];
}
public function muridall()
{
$search = request()->get('search');

$guruPage = request()->get('guru_page', 1);
$muridPage = request()->get('murid_page', 1);

$guru = User::where('role', 'guru')
    ->when($search, function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nisn_nip', 'like', "%{$search}%");
        });
    })
    ->orderBy('name', 'asc')
    ->paginate(10   , ['*'], 'guru_page', $guruPage);

$murid = User::where('role', 'murid')
    ->when($search, function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nisn_nip', 'like', "%{$search}%");
        });
    })
    ->orderBy('name', 'asc')
    ->paginate(10, ['*'], 'murid_page', $muridPage);

return [
    'guru' => $guru,
    'murid' => $murid,
];
}

}