<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;




class Task extends Model
{
    protected $fillable = [
    'id',    
    'classes_class',
        'teacher_nip',
        'title',
        'description',
        'image_path',
        'deadline'
    ];

protected $primaryKey = 'id';
public $incrementing = false;
protected $keyType = 'string';
protected function classes_class(): Attribute
{
    return Attribute::make(
        set: fn ($value) => strtoupper($value),
    );
}
public function submissions()
{
    return $this->hasMany(Submission::class);
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
