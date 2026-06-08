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
        $this->disableExpiredIklan();

        $data = Iklan::with('user')->latest()->get();
        return response()->json($data);
    }

    /**
     * Tambah Iklan Baru
     */
    public function tambahIklan(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'gambar'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'posisi'          => 'required|in:horizontal_728x90,sidebar_300x250',
            'link_tujuan'     => 'nullable|url',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $path = $request->file('gambar')->store('iklan', 'public');

        $this->disableExpiredIklan();

        // Cek apakah sudah ada iklan aktif di posisi yang sama dan masih dalam rentang tayang
        $now = now()->toDateString();
        $adaYangAktif = Iklan::where('posisi', $request->posisi)
            ->where('is_active', true)
            ->where(function($query) use ($now) {
                $query->whereNull('tanggal_mulai')
                    ->orWhere('tanggal_mulai', '<=', $now);
            })
            ->where(function($query) use ($now) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $now);
            })
            ->exists();

        $iklan = Iklan::create([
            'dibuat_oleh'     => Auth::id(),
            'judul'           => $request->judul,
            'gambar'          => $path,
            'posisi'          => $request->posisi,
            'link_tujuan'     => $request->link_tujuan,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_active'       => !$adaYangAktif, // aktif hanya jika belum ada yang aktif
        ]);

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
            'link_tujuan' => 'nullable|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus lebih besar atau sama dengan tanggal mulai',
        ]);

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            Storage::disk('public')->delete($iklan->gambar);
            // Simpan gambar baru
            $iklan->gambar = $request->file('gambar')->store('iklan', 'public');
        }

        $updateData = [
            'judul'          => $request->judul,
            'posisi'         => $request->posisi,
            'link_tujuan'    => $request->link_tujuan,
            'tanggal_mulai'  => $request->tanggal_mulai,
            'tanggal_selesai'=> $request->tanggal_selesai,
        ];

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($iklan->gambar);
            $updateData['gambar'] = $request->file('gambar')->store('iklan', 'public');
        }

        $iklan->update($updateData);

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

        // Jika akan diaktifkan, nonaktifkan dulu iklan lain di posisi yang sama
        if (!$iklan->is_active) {
            Iklan::where('posisi', $iklan->posisi)
                ->where('id', '!=', $id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $iklan->is_active = !$iklan->is_active;
        $iklan->save();

        return response()->json(['message' => 'Status iklan berhasil diubah!']);
    }

    /**
     * Disabled expired ads before returning data
     */
    private function disableExpiredIklan()
    {
        $now = now()->toDateString();

        Iklan::where('is_active', true)
            ->whereNotNull('tanggal_selesai')
            ->where('tanggal_selesai', '<', $now)
            ->update(['is_active' => false]);
    }

    /**
     * Ambil iklan aktif untuk ditampilkan di frontend viewers
     * Format dikelompokkan per posisi agar JS bisa baca langsung
     */
    public function getIklanAktif()
    {
        $this->disableExpiredIklan();

        $now = now()->toDateString();

        $data = Iklan::where('is_active', true)
            ->where(function($query) use ($now) {
                $query->whereNull('tanggal_mulai')
                    ->orWhere('tanggal_mulai', '<=', $now);
            })
            ->where(function($query) use ($now) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $now);
            })
            ->get();

        // Kelompokkan per posisi agar JS bisa langsung akses per slot
        $grouped = $data->groupBy('posisi');

        return response()->json([
            'status' => 'success',
            'data'   => [
                'horizontal_728x90' => $grouped->get('horizontal_728x90', collect())->values(),
                'sidebar_300x250'   => $grouped->get('sidebar_300x250', collect())->values(),
            ]
        ]);
    }
}