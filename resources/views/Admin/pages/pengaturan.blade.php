@extends('admin.master_admin')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ── FIX RESPONSIVE: Form & Grid HP ── */
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            box-sizing: border-box;
        }

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

        @media screen and (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr !important;
                gap: 16px;
            }

            .form-card, .profile-body {
                padding: 16px;
            }

            button[type="submit"] {
                width: 100%;
                justify-content: center;
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
@endsection

@section('konten')
<div class="page active" id="page-pengaturan">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div class="section-title" style="margin:0">Pengaturan Sistem</div>
    </div>

    <form method="POST" action="{{ url('/pengaturan') }}">
        @csrf
        <div class="form-card" style="margin-bottom:20px;">
            <div class="form-title">Identitas Situs</div>

            <div class="field">
                <label>Nama Situs</label>
                <input type="text" name="nama_situs" value="{{ old('nama_situs', $settings['nama_situs'] ?? 'Fenomena News Media') }}" style="padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 7px;">
            </div>

            <div class="field">
                <label>Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $settings['tagline'] ?? 'Delivering unbiased, in-depth reporting') }}" style="padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 7px;">
            </div>

            <button class="btn btn-red" type="submit">
                <i class="fas fa-save" style="margin-right: 6px;"></i> Simpan Perubahan
            </button>
        </div>
    </form>

    <form method="POST" action="{{ url('/pengaturan/profil') }}">
        @csrf
        <div class="card profile-card">
            <div class="card-hd">
                <div class="card-ht">Pengaturan Profil Admin</div>
                <div class="card-hm">Perbarui data diri dan kata sandi Anda</div>
            </div>

            <div class="profile-body">
                <div class="profile-section">
                    <div class="profile-section-title">
                        <h3>Informasi Dasar</h3>
                    </div>
                    <div class="profile-grid">
                        <div class="field">
                            <label>Username</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-user"></i>
                                <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" class="profile-input">
                            </div>
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="profile-input">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-section">
                    <div class="profile-section-title">
                        <h3>Keamanan (Ganti Password)</h3>
                    </div>
                    <div class="profile-grid">
                        <div class="field">
                            <label>Password Lama</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password_lama" placeholder="Masukkan password lama" class="profile-input">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>Password Baru</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-key"></i>
                                <input type="password" name="password_baru" placeholder="Masukkan password baru" class="profile-input">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                        <div class="field">
                            <label>Konfirmasi Password Baru</label>
                            <div class="profile-input-wrap">
                                <i class="fas fa-check-circle"></i>
                                <input type="password" name="password_baru_confirmation" placeholder="Ulangi password baru" class="profile-input">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-red" type="submit">
                    <i class="fas fa-shield-alt" style="margin-right: 6px;"></i> Update Profil & Keamanan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#tbTitle').text('Pengaturan Sistem');
        $('#tbCrumb').text('Admin / Pengaturan');
    });

    $(document).on('click', '.toggle-password', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Ganti icon mata terbuka/tertutup
        $(this).toggleClass('fa-eye fa-eye-slash');

        // Cari input di sebelahnya dan ganti tipe (text / password)
        const input = $(this).closest('.profile-input-wrap').find('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
</script>
@endsection
