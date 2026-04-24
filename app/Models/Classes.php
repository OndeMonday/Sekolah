<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Classes extends Model
{
protected $fillable = ['name','kelas'];

protected $primaryKey = 'name';
public $incrementing = false;
protected $keyType = 'string';
    
protected function name(): Attribute
{
    return Attribute::make(
        set: fn ($value) => strtoupper($value),
    );
}

protected function kelas(): Attribute
{
    return Attribute::make(
        set: fn ($value) => strtoupper($value),
    );
}
public function getRouteKeyName()
{
    return 'name';
}

}