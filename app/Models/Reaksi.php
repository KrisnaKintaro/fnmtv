<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaksi extends Model
{
    protected $fillable = [
        'berita_id',
        'user_id',
        'jenis_reaksi'
    ];

    public function berita() { return $this->belongsTo(Berita::class); }
    public function user() { return $this->belongsTo(User::class); }
}
