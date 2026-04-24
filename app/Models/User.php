<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'nisn_nip', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];
    protected $primaryKey = 'nisn_nip';
    public $incrementing = false;
    protected $keyType = 'string';
    protected function name(): Attribute
{
    return Attribute::make(
        set: fn ($value) => strtoupper($value),
    );
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