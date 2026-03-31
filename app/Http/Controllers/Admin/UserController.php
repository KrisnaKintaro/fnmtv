<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getDaftarPengguna()
    {
        $pengguna = User::latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar pengguna',
            'data' => $pengguna
        ]);
    }

    public function tambahPenggunaBaru(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,redaksi,editor,viewer'
        ], [
            'email.unique' => 'Email ini sudah dipakai cuy, gunakan email lain.',
            'role.in'      => 'Role tidak valid!'
        ]);

        $penggunaBaru = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Akun ' . $request->role . ' berhasil dibuat!',
            'data' => $penggunaBaru
        ]);
    }

    public function ubahDataPengguna(Request $request, $id)
    {
        $pengguna = User::find($id);

        if (!$pengguna) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan!'], 404);
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id, // Boleh email sama asal punya dia sendiri
            'role'     => 'required|in:admin,redaksi,editor,viewer'
        ]);

        $pengguna->username = $request->username;
        $pengguna->email    = $request->email;
        $pengguna->role     = $request->role;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pengguna berhasil diubah!',
            'data' => $pengguna
        ]);
    }

    /**
     * FUNGSI 4: MENGHAPUS PENGGUNA
     */
    public function hapusPengguna($id)
    {
        $pengguna = User::find($id);

        if (!$pengguna) {
            return response()->json(['status' => 'error', 'message' => 'User gagal dihapus!'], 404);
        }

        if (Auth::id() == $id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lu gak bisa hapus akun lu sendiri cuy!'
            ], 403);
        }

        $pengguna->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Akun berhasil dihapus permanen!'
        ]);
    }
}
