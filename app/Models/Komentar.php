<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komentar extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'berita_id',
        'user_id',
        'isi_komentar',
        'status_moderasi',
    ];

    public function berita() { return $this->belongsTo(Berita::class); }
    public function user() { return $this->belongsTo(User::class); }
}
