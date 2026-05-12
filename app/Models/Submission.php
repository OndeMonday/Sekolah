<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model

{
protected $fillable = [
    'task_id',
    'student_id',
    'image_path',
    'description',
    'status',
    'nilai',
    'approved_at',
    'submitted_at',
    'teacher_note'
];
public function task()
{
    return $this->belongsTo(Task::class);

}
}
