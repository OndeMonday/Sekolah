<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TeacherExport implements FromCollection
{
public function collection()
{
    return DB::table('class_teacher')
        ->join('users', 'users.nisn_nip', '=', 'class_teacher.teacher_nip')
        ->join('classes', 'classes.name', '=', 'class_teacher.classes_class')
        ->select(
            'users.name',
            'users.nisn_nip',
            'classes.name as class',
            'class_teacher.mapel',
            'class_teacher.walikelas'
        )
        ->get();
}
}