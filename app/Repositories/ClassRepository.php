<?php

namespace App\Repositories;

use App\Models\Classes;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ClassInterface;
use Illuminate\Support\Str;


class ClassRepository implements ClassInterface
{

public function all()
{
    return Classes::all();
}


    public function create(array $data)
    {
        return Classes::create($data);
    }

    public function delete(string $id)
    {
    $class = Classes::where('name', $id)->firstOrFail();
        return $class->delete();
    }
     public function update(string $url,array $name)
     {
    $class = Classes::where('name', $url)->firstOrFail();
    $class->update($name);
    return $class;
     }
    public function nama(int $id, string $nama)
    {
        $class = Classes::findOrFail($id);

        $exists = Classes::where('name', $nama)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            throw new \Exception('Nama kelas sudah digunakan');
        }

        $class->update(['name' => $nama]);

        return $class;
    }


public function assignStudents(string $kelas, array $siswa)
{
    Classes::where('name', $kelas)->firstOrFail();

    DB::table('class_student')
        ->whereIn('student_nisn', $siswa)
        ->where('class_name', '<>', $kelas) 
        ->delete();

    $data = collect($siswa)->map(function ($nisn) use ($kelas) {
        return [
            'class_name' => $kelas,    
            'student_nisn' => $nisn    
        ];
    })->toArray();

    DB::table('class_student')->insert($data);

    return User::whereIn('nisn_nip', $siswa)->get();
}

public function resetWaliKelas(string $className): int
{
    return DB::table('class_teacher')
        ->where('classes_class', $className)
        ->update(['walikelas' => 0]);
}   


public function attachTeacher(array $data): array
{
    $class = DB::table('classes')
        ->where('name', $data['kelas'])
        ->first();

    if (!$class) {
        throw new \Exception('Kelas tidak ditemukan');
    }

    DB::table('class_teacher')->insert([
        'classes_class' => $class->name,
        'teacher_nip' => $data['user_id'],
        'mapel' => $data['mapel'],
        'walikelas' => $data['walikelas'],
    ]);

    $user = DB::table('users')
        ->where('nisn_nip', $data['user_id'])
        ->first();

    return [
        'teacher_id' => $data['user_id'],
        'name' => $user?->name,
        'mapel' => $data['mapel'],
        'walikelas' => $data['walikelas']
    ];
}

public function getUsersByClass(string $kelas)
{
    $class = DB::table('classes')
        ->where('name', $kelas)
        ->first();

    if (!$class) {
        throw new \Exception('Kelas tidak ditemukan');
    }

    $teachers = DB::table('class_teacher')
        ->join('users', 'users.nisn_nip', '=', 'class_teacher.teacher_nip')
        ->join('classes', 'classes.name', '=', 'class_teacher.classes_class')
        ->where('classes.name', $kelas)
        ->select(
            'users.name',
            'users.nisn_nip',
            'users.role',
            'class_teacher.mapel',
            'class_teacher.walikelas'
        )
        ->get();

    $students = DB::table('class_student')
        ->join('users', 'users.nisn_nip', '=', 'class_student.student_nisn')
        ->join('classes', 'classes.name', '=', 'class_student.class_name')
        ->where('classes.name', $kelas)
        ->select(
            'users.name',
            'users.nisn_nip',
            'users.role'
        )
        ->get();

    $all = $teachers->concat($students)
        ->sortBy([
            ['role', 'asc'],
            ['name', 'asc']
        ])
        ->values();

    return [
        'class' => $class,
        'users' => $all
    ];
}
}