@extends('Viewers.master_viewers')

@section('konten')
<div class="container page-anim" style="max-width: 800px; margin: 40px auto; min-height: 60vh;">
    <div style="background: var(--white); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">

        {{-- HEADER --}}
        <div style="background: linear-gradient(135deg, var(--red), #8B0000); padding: 40px 20px; text-align: center; color: white;">
            <div style="width: 100px; height: 100px; border-radius: 50%; background: white; color: var(--red); font-size: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                <i class="fas fa-user-astronaut"></i>
            </div>
            <h2 style="margin: 0 0 5px;">Pengaturan Akun</h2>
            <p style="margin: 0; opacity: 0.8; font-size: 14px;">Kelola identitas dan keamanan akun FNM Anda</p>
        </div>

        <div style="padding: 40px;">

            {{-- ── SECTION 1: INFORMASI DASAR ── --}}
            <h3 style="font-size: 16px; margin-bottom: 20px; color: var(--text);">
                <i class="fas fa-id-card" style="color: var(--muted); margin-right: 8px;"></i> Informasi Dasar
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div class="field">
                    <label style="display:block; font-size:13px; font-weight:700; color:var(--muted); margin-bottom:8px;">Username</label>
                    <div style="position: relative;">
                        <i class="fas fa-at" style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--muted);"></i>
                        <input type="text" id="inputUsername" placeholder="Username Anda"
                            value="{{ Auth::user()->username }}"
                            style="width:100%; padding:12px 15px 12px 40px; border:1px solid var(--border); border-radius:8px; outline:none; font-family:inherit; font-size:14px;">
                    </div>
                </div>

                <div class="field">
                    <label style="display:block; font-size:13px; font-weight:700; color:var(--muted); margin-bottom:8px;">Alamat Email</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--muted);"></i>
                        <input type="email" id="inputEmail" placeholder="Email Anda"
                            value="{{ Auth::user()->email }}"
                            style="width:100%; padding:12px 15px 12px 40px; border:1px solid var(--border); border-radius:8px; outline:none; font-family:inherit; font-size:14px;">
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; margin-bottom:40px;">
                <button class="btn btn-red" id="btnSimpanProfil" onclick="simpanProfil()" style="padding:12px 24px; border-radius:8px;">
                    <i class="fas fa-save" style="margin-right:5px;"></i> Simpan Profil
                </button>
            </div>

            <hr style="border:none; border-top:1px dashed var(--border); margin-bottom:30px;">

            {{-- ── SECTION 2: GANTI PASSWORD ── --}}
            <h3 style="font-size: 16px; margin-bottom: 20px; color: var(--text);">
                <i class="fas fa-lock" style="color: var(--muted); margin-right: 8px;"></i> Ganti Password
            </h3>

            <div style="display:grid; grid-template-columns: 1fr; gap: 16px; margin-bottom:32px;">

                {{-- Password Lama --}}
                <div class="field">
                    <label style="display:block; font-size:13px; font-weight:700; color:var(--muted); margin-bottom:8px;">Password Saat Ini</label>
                    <div style="position:relative; display:flex; align-items:center;">
                        <i class="fas fa-lock" style="position:absolute; left:15px; color:var(--muted); pointer-events:none;"></i>
                        <input type="password" id="inputPasswordLama" placeholder="Masukkan password saat ini"
                            style="width:100%; padding:12px 45px 12px 40px; border:1px solid var(--border); border-radius:8px; outline:none; font-family:inherit; font-size:14px;">
                        <i class="fas fa-eye" id="toggleLama"
                            style="position:absolute; right:15px; cursor:pointer; color:var(--muted);"
                            onclick="togglePass('inputPasswordLama', 'toggleLama')"></i>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                    {{-- Password Baru --}}
                    <div class="field">
                        <label style="display:block; font-size:13px; font-weight:700; color:var(--muted); margin-bottom:8px;">Password Baru</label>
                        <div style="position:relative; display:flex; align-items:center;">
                            <i class="fas fa-key" style="position:absolute; left:15px; color:var(--muted); pointer-events:none;"></i>
                            <input type="password" id="inputPasswordBaru" placeholder="Minimal 6 karakter"
                                style="width:100%; padding:12px 45px 12px 40px; border:1px solid var(--border); border-radius:8px; outline:none; font-family:inherit; font-size:14px;">
                            <i class="fas fa-eye" id="toggleBaru"
                                style="position:absolute; right:15px; cursor:pointer; color:var(--muted);"
                                onclick="togglePass('inputPasswordBaru', 'toggleBaru')"></i>
                        </div>
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div class="field">
                        <label style="display:block; font-size:13px; font-weight:700; color:var(--muted); margin-bottom:8px;">Konfirmasi Password Baru</label>
                        <div style="position:relative; display:flex; align-items:center;">
                            <i class="fas fa-check-circle" style="position:absolute; left:15px; color:var(--muted); pointer-events:none;"></i>
                            <input type="password" id="inputPasswordKonfirmasi" placeholder="Ulangi password baru"
                                style="width:100%; padding:12px 45px 12px 40px; border:1px solid var(--border); border-radius:8px; outline:none; font-family:inherit; font-size:14px;">
                            <i class="fas fa-eye" id="toggleKonfirmasi"
                                style="position:absolute; right:15px; cursor:pointer; color:var(--muted);"
                                onclick="togglePass('inputPasswordKonfirmasi', 'toggleKonfirmasi')"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:15px;">
                <button type="button" class="btn btn-outline" style="padding:12px 24px; border-radius:8px;" onclick="window.history.back()">
                    Kembali
                </button>
                <button type="button" class="btn btn-red" id="btnGantiPassword" onclick="gantiPassword()" style="padding:12px 24px; border-radius:8px;">
                    <i class="fas fa-key" style="margin-right:5px;"></i> Ganti Password
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    /* ── TOGGLE SHOW/HIDE PASSWORD ── */
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    /* ── SIMPAN PROFIL (Username & Email) ── */
    function simpanProfil() {
        const btn      = document.getElementById('btnSimpanProfil');
        const username = document.getElementById('inputUsername').value.trim();
        const email    = document.getElementById('inputEmail').value.trim();

        if (!username || !email) {
            Toast.show('warning', 'Username dan email tidak boleh kosong!');
            return;
        }

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled  = true;

        $.ajax({
            url: '/api/redaksi/updateProfil',
            type: 'PUT',
            data: { username, email },
            success: function(res) {
                Toast.show('success', res.message || 'Profil berhasil diperbarui!');
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Gagal menyimpan profil.';
                Toast.show('error', msg);
            },
            complete: function() {
                btn.innerHTML = '<i class="fas fa-save" style="margin-right:5px;"></i> Simpan Profil';
                btn.disabled  = false;
            }
        });
    }

    /* ── GANTI PASSWORD ── */
    function gantiPassword() {
        const btn          = document.getElementById('btnGantiPassword');
        const passwordLama = document.getElementById('inputPasswordLama').value;
        const passwordBaru = document.getElementById('inputPasswordBaru').value;
        const konfirmasi   = document.getElementById('inputPasswordKonfirmasi').value;

        // Validasi sisi klien
        if (!passwordLama) {
            Toast.show('warning', 'Masukkan password saat ini dulu!');
            return;
        }
        if (!passwordBaru) {
            Toast.show('warning', 'Password baru tidak boleh kosong!');
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
                // Kosongkan field setelah sukses
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