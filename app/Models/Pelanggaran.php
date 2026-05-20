<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model

{
protected $table ='pelanggaran';
protected $fillable = [
'name',
'deskripsi',
];

}
