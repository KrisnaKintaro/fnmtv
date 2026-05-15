<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory;

    protected $table = 'iklans';
    protected $guarded = ['id'];

    /**
     * Relationship dengan User
     * Iklan dibuat oleh seorang User (Admin)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}