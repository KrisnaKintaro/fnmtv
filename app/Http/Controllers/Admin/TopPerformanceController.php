<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class TopPerformanceController extends Controller
{
    public function getTopPerformance()
    {
        $topBerita = Berita::select('id', 'user_id', 'judul_berita', 'slug', 'jumlah_view', 'waktu_publikasi')
            ->where('status_berita', 'Published')
            ->with(['user:id,username'])
            ->withCount(['komentar', 'reaksi'])
            ->orderBy('jumlah_view', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar berita terpopuler',
            'data' => $topBerita
        ]);
    }
}
