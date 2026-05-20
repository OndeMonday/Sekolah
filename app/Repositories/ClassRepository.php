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
    $classes = DB::table('classes')
        ->leftJoin('class_teacher', function ($join) {
            $join->on('classes.name', '=', 'class_teacher.classes_class')
                 ->where('class_teacher.walikelas', 1);
        })
        ->leftJoin('users', 'class_teacher.teacher_nip', '=', 'users.nisn_nip')
        ->select(
            'classes.*',
            'users.name as nama_walikelas'
        )
        ->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Berhasil mengambil daftar kelas',
        'data' => $classes
    ]);
}   


    public function create(array $data)
    {
        return Classes::create($data);
    }

    public function delete(string $name)
    {
    $class = Classes::where('name', $name)->firstOrFail();
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
        ->where('class_name', '!=', $kelas)
        ->delete();

    $data = collect($siswa)->map(fn ($nisn) => [
        'class_name' => $kelas,
        'student_nisn' => $nisn,
    ])->toArray();

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

    $users = DB::table('users')
    ->where('nisn_nip',$data['nisn_nip'])
    ->first();

    if (!$users) {
        throw new \Exception('Guru tidak ditemukan');
    } 


    DB::table('class_teacher')->insert([
        'classes_class' => $class->name,
        'teacher_nip' => $data['nisn_nip'],
        'mapel' => $data['mapel'],
        'walikelas' => $data['walikelas'],
    ]);

    $user = DB::table('users')
        ->where('nisn_nip', $data['nisn_nip'])
        ->first();

    $hasil=[
        'nip' => $data['nisn_nip'],
        'nama' => $user?->name,
        'mata_pelajaran' => $data['mapel'],
        'walikelas' => $data['walikelas'],
    ];
    return $hasil;
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
public function kelasajar(string $teacherId)
    {
        return DB::table('class_teacher')
            ->join('classes', 'classes.name', '=', 'class_teacher.classes_class')
            ->where('class_teacher.teacher_nip', $teacherId)
            ->select('classes.name')
            ->get();
}
public function removemurid(string $nisn)
{
      $hasil= DB::table('class_student')
        ->where('student_nisn', $nisn)
        ->delete();
        

    return $hasil;
}
}