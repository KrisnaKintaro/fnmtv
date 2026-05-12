<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class IklanController extends Controller
{
    /**
     * Ambil semua data iklan untuk tabel admin
     */
    public function getDaftarIklan()
    {
        $data = Iklan::with('admin')->latest()->get();
        return response()->json($data);
    }

    /**
     * Tambah Iklan Baru
     */
    public function tambahIklan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'posisi' => 'required|in:horizontal_728x90,sidebar_300x250',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Proses Upload Gambar
        $path = $request->file('gambar')->store('iklan', 'public');

        $iklan = Iklan::create([
            'judul' => $request->judul,
            'gambar' => $path,
            'posisi' => $request->posisi,
            'status' => 'aktif',
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'dibuat_oleh' => Auth::id(), // Mengambil ID admin yang sedang login
        ]);

        if($request->hasFile('gambar')){

            $path = $request->file('gambar')
                ->store('iklan', 'public');

            $iklan->gambar = $path;
        }

        return response()->json(['message' => 'Iklan berhasil ditambahkan!', 'data' => $iklan]);
    }

    /**
     * Update Data Iklan
     */
    public function ubahIklan(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'posisi' => 'required|in:horizontal_728x90,sidebar_300x250',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            Storage::disk('public')->delete($iklan->gambar);
            // Simpan gambar baru
            $iklan->gambar = $request->file('gambar')->store('iklan', 'public');
        }

        $iklan->update([
            'judul' => $request->judul,
            'posisi' => $request->posisi,
            'status' => $request->status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return response()->json(['message' => 'Iklan berhasil diperbarui!']);
    }

    /**
     * Hapus Iklan
     */
    public function hapusIklan($id)
    {
        $iklan = Iklan::findOrFail($id);
        
        // Hapus file gambarnya juga agar tidak memenuhi storage
        Storage::disk('public')->delete($iklan->gambar);
        $iklan->delete();

        return response()->json(['message' => 'Iklan telah dihapus!']);
    }

    /**
     * Toggle Status Aktif/Nonaktif (Quick Action)
     */
    public function ubahStatusIklan($id)
    {
        $iklan = Iklan::findOrFail($id);
        $iklan->status = ($iklan->status == 'aktif') ? 'nonaktif' : 'aktif';
        $iklan->save();

        return response()->json(['message' => 'Status iklan berhasil diubah!']);
    }
}