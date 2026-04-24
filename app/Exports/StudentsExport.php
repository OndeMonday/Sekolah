<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
public function collection()
{
    return DB::table('class_student')
        ->join('users', 'users.nisn_nip', '=', 'class_student.student_nisn')
        ->join('classes', 'classes.name', '=', 'class_student.class_name')
        ->where('users.role', 'murid')
        ->select(
            'users.name',
            'users.nisn_nip',
            'classes.name as class'
        )
        ->get();
}
}