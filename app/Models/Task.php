<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;



class Task extends Model
{
    protected $fillable = [
        'classes_class',
        'teacher_nip',
        'title',
        'description',
        'image_path',
        'deadline'
    ];
    protected function classes_class(): Attribute
{
    return Attribute::make(
        set: fn ($value) => strtoupper($value),
    );
}


}
