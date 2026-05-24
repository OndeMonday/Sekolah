<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MuridTelegramKontak extends Model
{
    use HasFactory;

    protected $table = 'murid_telegram_kontak';

    protected $fillable = [
        'student_nisn',
        'nama',
        'chat_id',
    ];
}