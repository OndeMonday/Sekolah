<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Submission extends Model

{
protected $fillable = [
    'id',
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

protected $primaryKey = 'id';
public $incrementing = false;
protected $keyType = 'string';

public function task()
{
    return $this->belongsTo(Task::class);
}
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (!$model->id) {
            $model->id = (string) Str::uuid();
        }
    });
}
}
