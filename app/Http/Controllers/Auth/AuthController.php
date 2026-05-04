<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Viewer', // Default role untuk registrasi umum
            'status' => 'Aktif',
        ]);

        // Laravel bakal kirim email verifikasi otomatis
        event(new Registered($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil! Silakan cek email lu buat verifikasi sebelum login.'
        ]);
    }

public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = clone User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // Lapor ke Satpam Blade biar @auth lu jalan!
            Auth::login($user);
            $request->session()->regenerate();

            // Pengecekan Verifikasi buat role hanya digunakan untuk role viewers aja.
            if (!$user->hasVerifiedEmail() && !in_array($user->role, ['Admin', 'Editor', 'Redaksi'])) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login sukses! Mengarahkan ke verifikasi...',
                    'redirect' => '/email/verify'
                ]);
            }

            // Lapor ke Satpam API (Bikin Token)
            $user->tokens()->delete();
            $token = $user->createToken('FNM-Token')->plainTextToken;

            $redirectUrl = '/'; // Default Viewer
            if ($user->role === 'Admin') $redirectUrl = '/analitik_statistik_berita';
            elseif ($user->role === 'Editor') $redirectUrl = '/editor';
            elseif ($user->role === 'Redaksi') $redirectUrl = '/redaksi-manajemen-berita';

            return response()->json([
                'status' => 'success',
                'message' => 'Login Sukses',
                'token' => $token,
                'redirect' => $redirectUrl
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Email atau password salah nih.'], 401);
    }

    public function logout(Request $request)
    {
        // 1. Cabut Token API-nya
        if (Auth::check()) {
            /** @var \App\Models\User $user */ // Kasih bisikan ini ke VS Code
            $user = Auth::user();
            $user->tokens()->delete();// Hapus semua token aja biar aman
        }

        // 2. Hapus buku tamu Satpam Blade (Session Cookie)
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['status' => 'success', 'message' => 'Logout berhasil!']);
    }

    public function checkVerify(Request $request)
    {
        return response()->json([
            'verified' => $request->user() && $request->user()->hasVerifiedEmail()
        ]);
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['status' => 'success', 'message' => 'Link dikirim!']);
    }

    // --- FUNGSI AKSI VERIFIKASI ---
    public function verifyEmail($id, $hash)
    {
        // Panggil model User
        $user = User::find($id);

        if (!$user || !hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Eitss, Link verifikasi tidak valid atau udah kadaluarsa cuy!');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return view('Auth.verifySuccess');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Bawaan Laravel buat ngirim email reset
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => 'success', 'message' => 'Link reset password udah dikirim ke email anda!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Gagal ngirim link, pastiin email anda terdaftar cuy.'], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['status' => 'success', 'message' => 'Mantap! Password berhasil diubah.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Gagal reset password, token mungkin kadaluarsa.'], 400);
    }
}
