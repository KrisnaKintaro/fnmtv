<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

class PengaturanController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', ['nama_situs', 'tagline', 'url_situs'])
            ->pluck('value', 'key')
            ->toArray();

        return view('Admin.pages.pengaturan', compact('settings'));
    }

    public function updateIdentity(Request $request)
    {
        $data = $request->validate([
            'nama_situs' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            // Hapus validasi url_situs dari sini
        ]);

        // Simpan ke database (hanya nama_situs dan tagline)
        Setting::updateOrCreate(['key' => 'nama_situs'], ['value' => $data['nama_situs']]);
        Setting::updateOrCreate(['key' => 'tagline'], ['value' => $data['tagline']]);
        // Jangan ubah url_situs - dibiarkan tetap seperti awal

        Session::flash('success', 'Pengaturan situs berhasil disimpan.');
        return back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->input('password_lama'), $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->input('password_baru'));
        $user->save();

        Session::flash('success', 'Password berhasil diperbarui.');
        return back();
    }
}