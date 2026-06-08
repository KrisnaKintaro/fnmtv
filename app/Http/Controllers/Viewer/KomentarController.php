<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function kirimKomentar(Request $request)
    {
        $request->validate([
            'berita_id'    => 'required|exists:beritas,id',
            'isi_komentar' => 'required|string|min:1|max:500',
        ], [
            'isi_komentar.required' => 'Isi komentarnya jangan dikosongin lah cuy.',
            'isi_komentar.min'      => 'Komentarnya kependekan, minimal 3 karakter ya.',
            'isi_komentar.max'      => 'Komentarnya kepanjangan bjir, maksimal 500 karakter aja.'
        ]);

        $berita = Berita::find($request->berita_id);
        if ($berita->status_berita !== 'Published') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Lu nggak bisa komentar di berita yang belum rilis cuy!'
            ], 403);
        }

        $komentarBaru = Komentar::create([
            'berita_id'    => $request->berita_id,
            'user_id'      => Auth::id(),
            'isi_komentar' => $request->isi_komentar,
            'status_moderasi' => 'Pending'
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Mantap! Komentar lu udah terkirim, tunggu di-approve Admin dulu ya cuy.',
            'data'    => $komentarBaru
        ]);
    }

    public function editKomentar(Request $request, $id)
    {
        $request->validate([
            'isi_komentar' => 'required|string|min:1|max:500',
        ], [
            'isi_komentar.required' => 'Isi komentarnya jangan dikosongin lah cuy.',
            'isi_komentar.min'      => 'Komentarnya kependekan, minimal 3 karakter ya.',
            'isi_komentar.max'      => 'Komentarnya kepanjangan bjir, maksimal 500 karakter aja.'
        ]);

        $komentar = Komentar::find($id);

        if (!$komentar) {
            return response()->json(['status' => 'error', 'message' => 'Komentar nggak ketemu cuy!'], 404);
        }

        // Cek apakah user yang login adalah pemilik komentar
        if ($komentar->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Lu nggak berhak ngedit komentar orang lain!'], 403);
        }

        $komentar->update([
            'isi_komentar' => $request->isi_komentar,
            'status_moderasi' => 'Pending' // Opsional: kembalikan ke Pending biar dicek Redaksi lagi
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Komentar lu berhasil diupdate dan menunggu persetujuan ulang.'
        ]);
    }

    public function hapusKomentar($id)
    {
        $komentar = Komentar::find($id);

        if (!$komentar) {
            return response()->json(['status' => 'error', 'message' => 'Komentar nggak ketemu cuy!'], 404);
        }

        // Cek apakah user yang login adalah pemilik komentar
        if ($komentar->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Lu nggak berhak ngapus komentar orang lain!'], 403);
        }

        $komentar->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Komentar berhasil dihapus.'
        ]);
    }
}
