<?php

namespace App\Models;

use App\Models\User;
use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'total_harga',
        'status',
        'kode_pembayaran',
        'metode_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function detail()
    {
        return $this->hasMany(
            DetailTransaksi::class
        );
    }
}