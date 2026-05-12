<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iklan extends Model
{
    use HasFactory;

    protected $table = 'iklans';

    // Primary key custom sesuai migrasi kamu
    protected $primaryKey = 'id_iklan';

    protected $fillable = [
        'judul',
        'gambar',
        'posisi',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'dibuat_oleh'
    ];

    /**
     * Relasi ke User (Admin yang membuat iklan)
     */
    public function admin()
    {
        // Karena foreign key kamu 'dibuat_oleh' dan owner key-nya 'id_user'
        return $this->belongsTo(User::class, 'dibuat_oleh', 'id_user');
    }

    /**
     * Scope untuk mempermudah filter iklan yang aktif dan sesuai jadwal
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')
            ->where(function($q) {
                $q->whereNull('tanggal_mulai')
                  ->orWhere('tanggal_mulai', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('tanggal_selesai')
                  ->orWhere('tanggal_selesai', '>=', now());
            });
    }
}