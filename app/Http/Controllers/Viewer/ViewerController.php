<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Reaksi;
use App\Models\ViewLog;
use Illuminate\Http\Request;

class ViewerController extends Controller
{
    public function getKategori()
    {
        // Hitung jumlah berita yang 'Published' di tiap kategori, lalu urutkan dari yang terbanyak
        $kategori = Kategori::withCount(['berita' => function($query) {
            $query->where('status_berita', 'Published');
        }])
        ->orderBy('berita_count', 'desc')
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    public function getBerita()
    {
        $baseQuery = Berita::with(['kategori', 'user'])->where('status_berita', 'Published');

        $headline = (clone $baseQuery)->latest('waktu_publikasi')->take(4)->get();
        $terbaru = (clone $baseQuery)->latest('waktu_publikasi')->take(10)->get();
        $trending = (clone $baseQuery)->orderBy('jumlah_view', 'desc')->take(5)->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'headline' => $headline,
                'terbaru'  => $terbaru,
                'trending' => $trending
            ]
        ]);
    }

    public function getBeritaDetail(Request $request, $slug)
    {
        $berita = Berita::with([
            'kategori',
            'user',
            'komentar' => function($query) {
                $query->where('status_moderasi', 'Approved')->latest();
            }
        ])
        ->where('slug', $slug)
        ->where('status_berita', 'Published')
        ->first();

        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        // --- LOGIKA TRACKING VIEW & ANTI SPAM ---
        $ipAddress = $request->ip();

        // Cek apakah IP ini udah baca berita ini dalam 2 jam terakhir (Biar ga di-spam F5)
        $sudahBaca = ViewLog::where('berita_id', $berita->id)
                            ->where('ip_address', $ipAddress)
                            ->where('created_at', '>=', now()->subHours(2))
                            ->exists();

        if (!$sudahBaca) {
            // 1. Tulis history-nya ke tabel view_logs
            ViewLog::create([
                'berita_id' => $berita->id,
                'ip_address' => $ipAddress
            ]);

            // 2. Tambahin +1 ke kolom jumlah_view (pake fungsi increment bawaan Laravel biar cepet)
            $berita->increment('jumlah_view');
        }

        // Hitung rekap reaksi untuk ditampilkan saat pertama kali load
        $rekapReaksi = [
            'suka'  => Reaksi::where('berita_id', $berita->id)->where('jenis_reaksi', 'suka')->count(),
            'cinta' => Reaksi::where('berita_id', $berita->id)->where('jenis_reaksi', 'cinta')->count(),
            'kaget' => Reaksi::where('berita_id', $berita->id)->where('jenis_reaksi', 'kaget')->count(),
            'sedih' => Reaksi::where('berita_id', $berita->id)->where('jenis_reaksi', 'sedih')->count(),
            'marah' => Reaksi::where('berita_id', $berita->id)->where('jenis_reaksi', 'marah')->count(),
        ];

        // Tempelkan data reaksi ke object berita
        $berita->reaksi_rekap = $rekapReaksi;

        return response()->json([
            'status' => 'success',
            'data' => $berita
        ]);
    }

    public function getBeritaByKategori($slug_kategori)
    {
        // Cari dulu kategorinya ada atau nggak
        $kategori = Kategori::where('slug', $slug_kategori)->first();

        if (!$kategori) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan!'
            ], 404);
        }

        // Ambil berita yang nyambung sama ID kategori tersebut
        $berita = Berita::with(['kategori', 'user'])
            ->where('kategori_id', $kategori->id)
            ->where('status_berita', 'Published')
            ->latest('waktu_publikasi')
            ->paginate(10); // Langsung pagination 10 per halaman

        return response()->json([
            'status' => 'success',
            'data' => [
                'kategori_info' => $kategori,
                'berita' => $berita
            ]
        ]);
    }

    public function searchBerita(Request $request)
    {
        $query = Berita::with(['kategori', 'user'])->where('status_berita', 'Published');

        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('judul_berita', 'like', "%{$keyword}%")
                  ->orWhere('isi_berita', 'like', "%{$keyword}%");
            });
        }

        $hasilPencarian = $query->latest('waktu_publikasi')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $hasilPencarian
        ]);
    }

    public function getBeritaPopuler()
    {
        $berita = Berita::with(['kategori', 'user'])
            ->where('status_berita', 'Published')
            ->orderBy('jumlah_view', 'desc') // Urutin dari view terbanyak
            ->paginate(10); // Pake paginate biar bisa diload per halaman

        return response()->json([
            'status' => 'success',
            'data' => $berita
        ]);
    }
}
