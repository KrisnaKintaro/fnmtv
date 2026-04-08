<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ViewerController extends Controller
{
    public function getBerita(Request $request)
    {
        $query = Berita::with('kategori')->where('status_berita', 'Published')->orderBy('created_at', 'desc');

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != 'home') {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan jenis (terkini, populer, editor)
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'populer':
                    $query->orderBy('jumlah_view', 'desc');
                    break;
                case 'editor':
                    // Untuk editor pick, asumsikan berita dengan view tinggi atau tambahkan field nanti
                    $query->orderBy('jumlah_view', 'desc')->limit(5);
                    break;
                default:
                    // terkini sudah default
                    break;
            }
        }

        $berita = $query->paginate(10);

        return response()->json([
            'data' => $berita->items(),
            'current_page' => $berita->currentPage(),
            'last_page' => $berita->lastPage(),
            'total' => $berita->total()
        ]);
    }

    public function getKategori()
    {
        $kategori = Kategori::all();

        return response()->json($kategori);
    }

    public function getBeritaDetail($slug)
    {
        $berita = Berita::with('kategori', 'user')->where('slug', $slug)->first();

        if (!$berita) {
            return response()->json(['error' => 'Berita tidak ditemukan'], 404);
        }

        // Increment view count
        $berita->increment('jumlah_view');

        return response()->json($berita);
    }

    public function searchBerita(Request $request)
    {
        $query = $request->get('q');

        $berita = Berita::with('kategori')
            ->where('status_berita', 'Published')
            ->where(function($q) use ($query) {
                $q->where('judul_berita', 'like', '%' . $query . '%')
                  ->orWhere('isi_berita', 'like', '%' . $query . '%');
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json($berita);
    }
}