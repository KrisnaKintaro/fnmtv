<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul_berita',
        'slug',
        'isi_berita',
        'foto_thumbnail',
        'foto_isi_berita',
        'status_berita',
        'jumlah_view',
        'catatan_penolakan',
        'waktu_publikasi'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function pendapatan() { return $this->hasOne(Pendapatan::class); }
    public function komentar() { return $this->hasMany(Komentar::class); }
    public function reaksi() { return $this->hasMany(Reaksi::class); }
    public function viewLogs() { return $this->hasMany(ViewLog::class); }
}
