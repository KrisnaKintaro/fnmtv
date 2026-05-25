@extends('redaksi.redaksi_master')

@section('title', 'Profil Saya')
@section('breadcrumb', 'Redaksi / Profil')

@section('css')
<style>
    /* ── FIX RESPONSIVE: Input Form & Grid HP ── */
    .profile-input-wrap {
        position: relative;
        width: 100%;
    }

    .profile-input-wrap i:first-child {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        z-index: 1;
    }

    .profile-input-wrap .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        cursor: pointer;
        z-index: 1;
    }

    .profile-input {
        width: 100%;
        padding: 10px 40px !important;
        border: 1.5px solid var(--border);
        border-radius: 6px;
        outline: none;
        font-size: 13px;
        transition: .2s;
        box-sizing: border-box;
    }

    .profile-input:focus {
        border-color: var(--red);
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media screen and (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr !important; /* Paksa numpuk ke bawah saat di HP */
            gap: 16px;
        }

        .profile-body {
            padding: 16px !important;
        }

        .btn-submit-profile {
            width: 100%;
            justify-content: center;
            padding: 12px;
            font-size: 14px;
        }
    }
</style>
@endsection

@section('konten')
<div id="page-profil" class="page active">
    <div class="section-title">Pengaturan Akun</div>

    <div class="card profile-card">
        <div class="card-hd">
            <div class="card-ht">Profil Redaksi</div>
            <div class="card-hm">Kelola identitas dan keamanan akun Anda</div>
        </div>

        <div class="profile-body" style="padding: 24px;">
            <form id="formProfilRedaksi">

                <div style="margin-bottom: 24px;">
                    <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                        Informasi Dasar
                    </h3>
                    <div class="profile-grid">
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Username</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-user"></i>
                                <input type="text" id="profUsername" value="{{ Auth::user()->username }}" class="profile-input" required>
                            </div>
                        </div>
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Email</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="profEmail" value="{{ Auth::user()->email }}" class="profile-input" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                        Keamanan (Ganti Password)
                    </h3>
                    <div class="profile-grid">
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Password Lama</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="profCurrentPass" placeholder="Masukkan password lama" class="profile-input">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Password Baru</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-key"></i>
                                <input type="password" id="profPassword" placeholder="Masukkan password baru" class="profile-input">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                        <div class="field" style="margin-bottom: 0;">
                            <label style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 6px; display: block;">Konfirmasi Password Baru</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-check-circle"></i>
                                <input type="password" id="profPasswordConfirm" placeholder="Ulangi password baru" class="profile-input">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 24px;">
                    <button type="submit" class="btn btn-red btn-submit-profile">
                        <i class="fas fa-save" style="margin-right: 8px;"></i> Simpan Perubahan
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
        // Fitur Hide/Show Password
        $(document).on('click', '.toggle-password', function(e) {
            e.preventDefault();
            e.stopPropagation();

            $(this).toggleClass('fa-eye fa-eye-slash');

            const input = $(this).siblings('input');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });

        $('#formProfilRedaksi').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();

            btn.html('<i class="fas fa-spinner fa-spin" style="margin-right:8px;"></i> Menyimpan...').prop('disabled', true);

            const currentPassword = $('#profCurrentPass').val();
            const password = $('#profPassword').val();
            const confirmPassword = $('#profPasswordConfirm').val();

            if (password && password !== confirmPassword) {
                Toast.show('warning', 'Konfirmasi password baru tidak cocok!');
                btn.html(originalText).prop('disabled', false);
                return;
            }

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
                    $('#profCurrentPass, #profPassword, #profPasswordConfirm').val('');

                    // Sinkronisasi data ke sidebar induk
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
