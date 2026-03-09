<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendapatan extends Model
{
    protected $fillable = [
        'berita_id',
        'user_id',
        'nominal_pendapatan',
        'status_pembayaran',
        'waktu_pembayaran',
    ];

    public function berita() { return $this->belongsTo(Berita::class); }
    public function user() { return $this->belongsTo(User::class); }
}
