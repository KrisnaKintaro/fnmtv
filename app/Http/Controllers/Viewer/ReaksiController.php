<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Reaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReaksiController extends Controller
{
    public function toggleReaksi(Request $request)
    {
        $request->validate([
            'berita_id'    => 'required|exists:beritas,id',
            'jenis_reaksi' => 'required|in:suka,cinta,kaget,sedih,marah'
        ]);

        // Karena fitur login buat Viewers mungkin belum ada,
        // kita tembak ke user_id 1 dulu sementara buat ngetes API-nya.
        $userId = Auth::id() ?: 1;

        $berita = Berita::find($request->berita_id);

        if ($berita->status_berita !== 'Published') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Lu nggak bisa ngasih reaksi di berita yang belum rilis cuy!'
            ], 403);
        }

        // Cek apakah user udah pernah ngasih reaksi di berita ini
        $reaksiAwal = Reaksi::where('berita_id', $request->berita_id)
                            ->where('user_id', $userId)
                            ->first();

        if ($reaksiAwal) {
            if ($reaksiAwal->jenis_reaksi === $request->jenis_reaksi) {
                // Klik tombol yang sama = Batalin (Unlike)
                $reaksiAwal->delete();
                $pesan = 'Reaksi ditarik.';
            } else {
                // Klik tombol yang beda = Update Reaksi (misal dari Suka jadi Marah)
                $reaksiAwal->update(['jenis_reaksi' => $request->jenis_reaksi]);
                $pesan = 'Reaksi diubah.';
            }
        } else {
            // Belum pernah reaksi = Bikin Baru
            Reaksi::create([
                'berita_id'    => $request->berita_id,
                'user_id'      => $userId,
                'jenis_reaksi' => $request->jenis_reaksi
            ]);
            $pesan = 'Reaksi ditambahkan.';
        }

        // Hitung ulang rekap reaksinya buat dikirim balik ke Frontend
        // Biar tombol angkanya bisa langsung berubah realtime
        $rekapReaksi = [
            'suka'  => Reaksi::where('berita_id', $request->berita_id)->where('jenis_reaksi', 'suka')->count(),
            'cinta' => Reaksi::where('berita_id', $request->berita_id)->where('jenis_reaksi', 'cinta')->count(),
            'kaget' => Reaksi::where('berita_id', $request->berita_id)->where('jenis_reaksi', 'kaget')->count(),
            'sedih' => Reaksi::where('berita_id', $request->berita_id)->where('jenis_reaksi', 'sedih')->count(),
            'marah' => Reaksi::where('berita_id', $request->berita_id)->where('jenis_reaksi', 'marah')->count(),
        ];

        return response()->json([
            'status'  => 'success',
            'message' => $pesan,
            'data'    => $rekapReaksi
        ]);
    }
}
