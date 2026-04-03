<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;


class StatistikInteraksiBeritaController extends Controller
{
    public function getStatistikInteraksi()
    {
        $statistik = Berita::select('id', 'user_id', 'judul_berita', 'jumlah_view', 'waktu_publikasi')
            ->where('status_berita', 'Published')
            ->with(['user:id,username'])
            ->withCount(['komentar', 'reaksi'])

            ->orderBy('waktu_publikasi', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data statistik interaksi berita',
            'data' => $statistik
        ]);
    }
}
