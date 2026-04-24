<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentsPerClassExport implements FromCollection, WithTitle
{
    protected $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

public function collection()
{
    return DB::table('class_student')
        ->join('users','users.nisn_nip','=','class_student.student_nisn')
        ->join('classes','classes.name','=','class_student.class_name')
        ->where('class_student.class_name', $this->className)
        ->where('users.role','murid') 
        ->select(
            'users.nisn_nip',
            'users.name',
            'classes.name as class'
        )
        ->get();
}

    public function title(): string
    {
        return $this->className;
    }
}