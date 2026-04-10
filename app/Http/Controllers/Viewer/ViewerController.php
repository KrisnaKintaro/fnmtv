<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ViewerController extends Controller
{
    /**
     * 1. Ambil Data Kategori (Buat render Navbar & Dropdown)
     */
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

    /**
     * 2. Ambil Berita untuk Halaman Home
     */
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

    /**
     * 3. Ambil Detail Berita + Komentar + REAKSI (Berdasarkan Slug)
     */
    public function getBeritaDetail($slug)
    {
        $berita = Berita::with([
            'kategori',
            'user',
            'komentar' => function($query) {
                $query->where('status_moderasi', 'Approved')->latest();
            },
            'komentar.user',
            'reaksi' // <--- INI YANG LU CARI CUY!
        ])
        ->where('slug', $slug)
        ->where('status_berita', 'Published')
        ->first();

        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan atau belum dirilis cuy!'
            ], 404);
        }

        $berita->increment('jumlah_view');

        // Bikin rekap jumlah per reaksi biar frontend gak repot ngitung
        $rekapReaksi = [
            'suka'  => $berita->reaksi->where('jenis_reaksi', 'suka')->count(),
            'cinta' => $berita->reaksi->where('jenis_reaksi', 'cinta')->count(),
            'kaget' => $berita->reaksi->where('jenis_reaksi', 'kaget')->count(),
            'sedih' => $berita->reaksi->where('jenis_reaksi', 'sedih')->count(),
            'marah' => $berita->reaksi->where('jenis_reaksi', 'marah')->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'berita' => $berita,
                'rekap_reaksi' => $rekapReaksi
            ]
        ]);
    }

    /**
     * 4. [BARU] Ambil Berita Berdasarkan Slug Kategori
     */
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

    /**
     * 5. Pencarian Murni Berdasarkan Teks (Dari Navbar)
     */
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
