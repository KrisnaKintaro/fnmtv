@extends('viewers.master_viewers')

@section('konten')
<div class="container page-anim user-profile-container" style="max-width: 800px; margin: 20px auto; min-height: 60vh; padding: 10px 15px;">
    <div style="background: var(--white); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">

        {{-- HEADER --}}
        <div style="background: linear-gradient(135deg, var(--red), #8B0000); padding: 40px 20px; text-align: center; color: white;">
            <div style="width: 100px; height: 100px; border-radius: 50%; background: white; color: var(--red); font-size: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                <i class="fas fa-user-astronaut"></i>
            </div>
            <h2 style="margin: 0 0 5px;">Pengaturan Akun</h2>
            <p style="margin: 0; opacity: 0.8; font-size: 14px;">Kelola identitas dan keamanan akun FNM Anda</p>
        </div>

        {{-- FORM BODY (Padding dibuat dinamis lewat style class di bawah) --}}
        <div class="profile-body-content">

            {{-- ── SECTION 1: INFORMASI PROFIL ── --}}
            <div style="margin-bottom: 40px;">
                <h3 style="font-family: 'Merriweather', serif; font-size: 18px; color: var(--text); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 2px solid var(--border);">
                    <i class="fas fa-id-card" style="color: var(--red); margin-right: 8px;"></i>Informasi Dasar
                </h3>

                <div class="profile-form-group">
                    <label class="profile-form-label">Username</label>
                    <div style="flex: 1; width: 100%;">
                        <input type="text" id="inputUsername" class="profile-form-input" placeholder="Masukkan username baru" value="{{ Auth::user()->username }}">
                        <small style="color: var(--muted); font-size: 12px; display: block; margin-top: 4px;">Nama pengguna lu yang bakal tampil di kolom komentar.</small>
                    </div>
                </div>

                <div class="profile-form-group">
                    <label class="profile-form-label">Alamat Email</label>
                    <div style="flex: 1; width: 100%;">
                        <input type="email" class="profile-form-input" value="{{ Auth::user()->email }}" disabled style="background: #f9f8f5; cursor: not-allowed; color: var(--muted);">
                        <small style="color: var(--muted); font-size: 12px; display: block; margin-top: 4px;">Email utama terverifikasi. Bagian ini nggak bisa diganti cuy.</small>
                    </div>
                </div>

                <div class="profile-form-action-row">
                    <button class="btn btn-red profile-submit-btn" id="btnSimpanProfil" onclick="simpanProfil()">
                        <i class="fas fa-save" style="margin-right: 5px;"></i>Simpan Perubahan
                    </button>
                </div>
            </div>

            {{-- ── SECTION 2: KEAMANAN / PASSWORD ── --}}
            <div>
                <h3 style="font-family: 'Merriweather', serif; font-size: 18px; color: var(--text); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 2px solid var(--border);">
                    <i class="fas fa-shield-alt" style="color: var(--red); margin-right: 8px;"></i>Keamanan Akun
                </h3>

                <div class="profile-form-group">
                    <label class="profile-form-label">Password Lama</label>
                    <input type="password" id="inputPasswordLama" class="profile-form-input" placeholder="Masukkan password lama lu">
                </div>

                <div class="profile-form-group">
                    <label class="profile-form-label">Password Baru</label>
                    <input type="password" id="inputPasswordBaru" class="profile-form-input" placeholder="Minimal 6 karakter">
                </div>

                <div class="profile-form-group">
                    <label class="profile-form-label">Konfirmasi Password</label>
                    <input type="password" id="inputPasswordKonfirmasi" class="profile-form-input" placeholder="Ulangi password baru">
                </div>

                <div class="profile-form-action-row">
                    <button class="btn btn-outline profile-submit-btn" id="btnGantiPassword" onclick="gantiPassword()">
                        <i class="fas fa-key" style="margin-right: 5px;"></i>Ganti Password
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- ── CSS RESPONSIVE OVERRIDE KHUSUS HALAMAN PROFIL ── --}}
<style>
    /* Styling Dasar agar flexbox bekerja dinamis */
    .profile-body-content {
        padding: 40px;
    }
    .profile-form-group {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        width: 100%;
        box-sizing: border-box;
    }
    .profile-form-label {
        width: 200px;
        font-weight: 600;
        font-size: 14px;
        color: var(--text);
        padding-top: 10px;
        flex-shrink: 0;
    }
    .profile-form-input {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 10px 14px;
        font-family: inherit;
        font-size: 14px;
        color: var(--text);
        outline: none;
        transition: 0.15s;
        box-sizing: border-box;
    }
    .profile-form-input:focus {
        border-color: var(--red);
    }
    .profile-form-action-row {
        padding-left: 200px;
        width: 100%;
        box-sizing: border-box;
    }
    .profile-submit-btn {
        padding: 11px 24px;
        font-size: 14px;
        border-radius: 8px;
    }

    /* ── MEDIA QUERIES RESPONSIVITAS HP & TABLET ── */
    @media screen and (max-width: 650px) {
        .profile-body-content {
            padding: 24px 16px; /* Perkecil padding kontainer utama di HP */
        }
        .profile-form-group {
            flex-direction: column; /* Label pindah ke atas inputan (Mode vertikal) */
            align-items: stretch;
            gap: 6px;
            margin-bottom: 16px;
        }
        .profile-form-label {
            width: 100%; /* Lebar label penuhi layar */
            padding-top: 0;
            font-size: 13px;
        }
        .profile-form-action-row {
            padding-left: 0; /* Kembalikan offset padding tombol ke kiri */
        }
        .profile-submit-btn {
            width: 100%; /* Tombol penuhi lebar HP agar mudah di-tap jempol */
            display: flex;
            justify-content: center;
        }
    }
</style>
@endsection

@section('js')
<script>
    // FUNGSI SIMPAN INFO PROFIL (AJAX AMAN 100%)
    function simpanProfil() {
        const username = document.getElementById('inputUsername').value.trim();
        const btn      = document.getElementById('btnSimpanProfil');

        if (!username) {
            Toast.show('warning', 'Username nggak boleh kosong cuy!');
            return;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled  = true;

        $.ajax({
            url: '/api/auth/update-profil',
            type: 'POST',
            data: { username: username },
            success: function(res) {
                Toast.show('success', res.message || 'Profil berhasil diperbarui!');
                // Update text di navbar secara live kalau ada elemen targetnya
                const navNameEl = document.querySelector('.user-profile-menu span');
                if (navNameEl) navNameEl.textContent = username;
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Gagal memperbarui profil.';
                Toast.show('error', msg);
            },
            complete: function() {
                btn.innerHTML = '<i class="fas fa-save" style="margin-right:5px;"></i> Simpan Perubahan';
                btn.disabled  = false;
            }
        });
    }

    // FUNGSI GANTI PASSWORD (AJAX AMAN 100%)
    function gantiPassword() {
        const passwordLama       = document.getElementById('inputPasswordLama').value;
        const passwordBaru       = document.getElementById('inputPasswordBaru').value;
        const konfirmasi         = document.getElementById('inputPasswordKonfirmasi').value;
        const btn                = document.getElementById('btnGantiPassword');

        if (!passwordLama || !passwordBaru || !konfirmasi) {
            Toast.show('warning', 'Semua field password wajib diisi cuy!');
            return;
        }
        if (passwordBaru.length < 6) {
            Toast.show('warning', 'Password baru minimal 6 karakter!');
            return;
        }
        if (passwordBaru !== konfirmasi) {
            Toast.show('error', 'Konfirmasi password tidak cocok!');
            return;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        btn.disabled  = true;

        $.ajax({
            url: '/api/auth/ganti-password',
            type: 'POST',
            data: {
                password_lama       : passwordLama,
                password_baru       : passwordBaru,
                password_konfirmasi : konfirmasi
            },
            success: function(res) {
                Toast.show('success', res.message || 'Password berhasil diganti!');
                document.getElementById('inputPasswordLama').value        = '';
                document.getElementById('inputPasswordBaru').value        = '';
                document.getElementById('inputPasswordKonfirmasi').value  = '';
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Gagal mengganti password.';
                Toast.show('error', msg);
            },
            complete: function() {
                btn.innerHTML = '<i class="fas fa-key" style="margin-right:5px;"></i> Ganti Password';
                btn.disabled  = false;
            }
        });
    }
</script>
@endsection
