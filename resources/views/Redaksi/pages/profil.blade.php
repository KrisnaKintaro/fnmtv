@extends('Redaksi.redaksi_master')

@section('konten')
<div id="page-profil" class="page active">
    <div class="section-title">Pengaturan Akun</div>

    <div class="card profile-card">
        <div class="card-hd">
            <div class="card-ht">Profil Redaksi</div>
            <div class="card-hm">Kelola identitas dan keamanan akun Anda</div>
        </div>

        <div style="padding: 24px;">
            <form id="formProfilRedaksi">
                <div style="margin-bottom: 24px;">
                    <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                        Informasi Dasar
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Username</label>
                            <div style="position: relative;">
                                <i class="fas fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                                <input type="text" id="profUsername" value="{{ Auth::user()->username }}" required style="width: 100%; padding: 10px 15px 10px 40px; border: 1.5px solid var(--border); border-radius: 6px; outline: none; font-size: 13px; transition: 0.2s;">
                            </div>
                        </div>
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Alamat Email</label>
                            <div style="position: relative;">
                                <i class="fas fa-envelope" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                                <input type="email" id="profEmail" value="{{ Auth::user()->email }}" required style="width: 100%; padding: 10px 15px 10px 40px; border: 1.5px solid var(--border); border-radius: 6px; outline: none; font-size: 13px; transition: 0.2s;">
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; border-bottom: 1px solid var(--border); padding-bottom: 8px; margin-bottom: 16px;">
                        <h3 style="font-size: 14px; font-weight: 700; margin: 0;">Keamanan & Password</h3>
                        <span style="font-size: 11px; color: var(--muted);">Kosongkan jika tidak diubah</span>
                    </div>

                    <div class="field" style="margin-bottom: 20px; max-width: calc(50% - 10px);">
                        <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Password Sekarang</label>
                        <div style="position: relative;">
                            <i class="fas fa-lock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                            <input type="password" id="profCurrentPass" placeholder="Masukkan password lama" style="width: 100%; padding: 10px 40px 10px 40px; border: 1.5px solid var(--border); border-radius: 6px; outline: none; font-size: 13px; transition: 0.2s;">
                            <i class="fas fa-eye toggle-password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--muted); pointer-events: auto !important; z-index: 10;"></i>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Password Baru</label>
                            <div style="position: relative;">
                                <i class="fas fa-key" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                                <input type="password" id="profPassword" placeholder="Minimal 8 karakter" style="width: 100%; padding: 10px 40px 10px 40px; border: 1.5px solid var(--border); border-radius: 6px; outline: none; font-size: 13px; transition: 0.2s;">
                                <i class="fas fa-eye toggle-password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--muted); pointer-events: auto !important; z-index: 10;"></i>
                            </div>
                        </div>
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Konfirmasi Password</label>
                            <div style="position: relative;">
                                <i class="fas fa-check-circle" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                                <input type="password" id="profPasswordConfirm" placeholder="Ulangi password baru" style="width: 100%; padding: 10px 40px 10px 40px; border: 1.5px solid var(--border); border-radius: 6px; outline: none; font-size: 13px; transition: 0.2s;">
                                <i class="fas fa-eye toggle-password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--muted); pointer-events: auto !important; z-index: 10;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-red" id="btnSimpanProfil" style="padding: 10px 20px;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Update teks topbar
        $('#tbTitle').text('Profil Saya');
        $('#tbCrumb').text('Redaksi / Profil Saya');

        // Bikin border merah pas input di-focus
        $('input').on('focus', function() {
            $(this).css('border-color', 'var(--red)');
        }).on('blur', function() {
            $(this).css('border-color', 'var(--border)');
        });

        // HANDLE SUBMIT FORM
        $('#formProfilRedaksi').on('submit', function(e) {
            e.preventDefault();

            const currentPassword = $('#profCurrentPass').val();
            const password = $('#profPassword').val();
            const confirmPassword = $('#profPasswordConfirm').val();

            // VALIDASI FRONTEND
            if (password || confirmPassword) {
                if (!currentPassword) {
                    Toast.show('warning', 'Masukkan password sekarang kalau mau ganti password baru cuy!');
                    return;
                }
                if (password !== confirmPassword) {
                    Toast.show('warning', 'Waduh, Password dan Konfirmasi Password tidak sama cuy!');
                    return;
                }
                if (password.length < 8) {
                    Toast.show('warning', 'Password baru minimal harus 8 karakter!');
                    return;
                }
            }

            const btn = $('#btnSimpanProfil');
            const originalText = btn.html();
            btn.html('Menyimpan...').prop('disabled', true);

            const payload = {
                _method: 'PUT',
                username: $('#profUsername').val(),
                email: $('#profEmail').val(),
                current_password: currentPassword,
                password: password,
                password_confirmation: confirmPassword
            };

            $.ajax({
                url: '/api/redaksi/updateProfil',
                type: 'POST',
                data: payload,
                success: function(res) {
                    Toast.show('success', res.message || 'Profil berhasil diperbarui!');
                    btn.html(originalText).prop('disabled', false);

                    // Kosongkan semua input password setelah berhasil
                    $('#profCurrentPass, #profPassword, #profPasswordConfirm').val('');

                    // Update tampilan data diri di Sidebar
                    $('.s-uname').text(payload.username);
                    $('.s-avatar').text(payload.username.charAt(0).toUpperCase());
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Gagal menyimpan profil.';
                    if (xhr.responseJSON?.errors) {
                        msg = Object.values(xhr.responseJSON.errors)[0][0];
                    }
                    Toast.show('error', msg);
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
