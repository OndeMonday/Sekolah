<?php
namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
        public function findBynisn_nip(string $data)
    {
        return User::where('nisn_nip', $data)->first();
    }
            public function create(array $data)
    {
        return User::create($data);
    }




public function updateRole(string $id, string $role)
{
    $user = User::where('nisn_nip', $id)->first();

    if (!$user) return null;
    

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

    return DB::table('class_student')
    ->join('users', 'users.nisn_nip', '=', 'class_student.student_nisn')
    ->where('class_student.class_name', $name)
    ->select('users.name', 'users.nisn_nip','users.role')
    ->orderBy('name','asc')
    ->get();
}

}