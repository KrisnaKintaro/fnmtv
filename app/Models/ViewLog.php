<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewLog extends Model
{
    protected $fillable = [
        'berita_id',
        'ip_address'
    ];

    public function berita() { return $this->belongsTo(Berita::class); }
}
