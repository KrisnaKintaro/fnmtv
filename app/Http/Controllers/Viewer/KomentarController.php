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
            'isi_komentar' => 'required|string|min:3|max:500',
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
            'user_id'      => Auth::id() || 1, // Diambil dari session user yang login
            'isi_komentar' => $request->isi_komentar,
            'status_moderasi' => 'Pending'
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Mantap! Komentar lu udah terkirim, tunggu di-approve Admin dulu ya cuy.',
            'data'    => $komentarBaru
        ]);
    }
}
