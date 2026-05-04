<?php

namespace App\Http\Controllers\Redaksi;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pendapatan;
use Illuminate\Http\Request;

class VerifikasiBeritaController extends Controller
{
    // List berita yang masuk (Pending, Published, dan Rejected untuk monitoring)
    public function getBeritaMasuk()
    {
        $data = Berita::whereIn('status_berita', ['Pending', 'Published', 'Rejected'])
                ->with(['user:id,id,username', 'kategori:id,id,nama_kategori'])
                ->orderBy('created_at', 'DESC')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'judul_berita' => $item->judul_berita,
                        'slug' => $item->slug,
                        'isi_berita' => $item->isi_berita,
                        'foto_thumbnail' => $item->foto_thumbnail,
                        'status_berita' => $item->status_berita,
                        'catatan_penolakan' => $item->catatan_penolakan,
                        'created_at' => $item->created_at,
                        'waktu_publikasi' => $item->waktu_publikasi,
                        'user' => [
                            'id' => $item->user?->id,
                            'username' => $item->user?->username,
                            'name' => $item->user?->name
                        ],
                        'kategori' => [
                            'id' => $item->kategori?->id,
                            'nama_kategori' => $item->kategori?->nama_kategori,
                            'slug' => $item->kategori?->slug
                        ]
                    ];
                });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar antrean verifikasi berita.',
            'data' => $data
        ], 200);
    }

    // Proses Verifikasi (ACC/Tolak/Unpublish)
    public function verifikasiBerita(Request $request, $id)
    {
        $request->validate([
            'status_berita'     => 'required|in:Published,Rejected,Pending',
            'catatan_penolakan' => 'required_if:status_berita,Rejected'
        ], [
            'catatan_penolakan.required_if' => 'Catatan penolakan wajib diisi kalau artikel ditolak cuy!'
        ]);

        $berita = Berita::findOrFail($id);

        // --- LOGIKA OTOMATISASI PENDAPATAN (Revisi Krisna) ---
        if ($request->status_berita === 'Published') {
            // Skenario 1: Redaksi ACC Berita -> Buat Tagihan Otomatis
            Pendapatan::firstOrCreate(
                ['berita_id' => $berita->id],
                [
                    'user_id' => $berita->user_id, // Editor yang punya berita
                    'nominal_pendapatan' => 0,
                    'status_pembayaran' => 'Unpaid'
                ]
            );
        } else {
            // Skenario 2: Redaksi Nolak Berita ATAU Batalin Publish (Unpublish / Pending)
            $pendapatan = Pendapatan::where('berita_id', $berita->id)->first();

            if ($pendapatan) {
                if ($pendapatan->status_pembayaran === 'Paid') {
                    // Mencegah Redaksi narik berita yang udah cair duitnya
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Berita ini sudah lunas dibayar oleh Admin, tidak bisa di-reject atau ditarik!'
                    ], 403);
                } else {
                    // Kalau masih Unpaid, hapus tagihannya biar negara nggak rugi
                    $pendapatan->delete();
                }
            }
        }
        // --- END LOGIKA PENDAPATAN ---

        $updateData = [
            'status_berita' => $request->status_berita
        ];

        if ($request->status_berita == 'Published') {
            $updateData['waktu_publikasi'] = now();
            $updateData['catatan_penolakan'] = null;
        } else if ($request->status_berita == 'Rejected') {
            $updateData['catatan_penolakan'] = $request->catatan_penolakan;
            $updateData['waktu_publikasi'] = null;
        } else if ($request->status_berita == 'Pending') {
            // 🔴 FIX 2: Bersihin tanggal publikasi kalau ditarik jadi Unpublish (Pending)
            $updateData['catatan_penolakan'] = null;
            $updateData['waktu_publikasi'] = null;
        }

        $berita->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Status berita berhasil diperbarui menjadi ' . $request->status_berita,
            'data' => [
                'id' => $berita->id,
                'status_berita' => $berita->status_berita,
                'waktu_publikasi' => $berita->waktu_publikasi,
                'catatan_penolakan' => $berita->catatan_penolakan
            ]
        ], 200);
    }

    public function getNotifikasi()
    {
        // Cari semua berita yang statusnya masih 'Pending'
        // Kita join (with) relasi user biar bisa nampilin nama Editornya
        $beritaPending = Berita::with('user')
            ->where('status_berita', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Format datanya biar sesuai sama ekspektasi SmartNotif.js
        $notifData = $beritaPending->map(function ($berita) {
            return [
                'id' => $berita->id,
                'type' => 'pending',
                'icon' => '📋',
                'title' => 'Perlu Ditinjau: ' . ($berita->user->username ?? 'Editor'),
                'message' => 'Artikel "' . $berita->judul_berita . '" menunggu persetujuan.',
                'time' => $berita->created_at->diffForHumans(), // Pake Carbon biar jadi "5 menit lalu"
            ];
        });

        // Return dalam bentuk JSON
        return response()->json([
            'status' => 'success',
            'data' => $notifData
        ]);
    }
}
