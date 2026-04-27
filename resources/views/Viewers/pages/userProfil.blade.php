@extends('Viewers.master_viewers')

@section('konten')
<div class="container page-anim" style="max-width: 800px; margin: 40px auto; min-height: 60vh;">
    <div style="background: var(--white); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">

        <div style="background: linear-gradient(135deg, var(--primary), #8B0000); padding: 40px 20px; text-align: center; color: white;">
            <div style="width: 100px; height: 100px; border-radius: 50%; background: white; color: var(--primary); font-size: 40px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                <i class="fas fa-user-astronaut"></i>
            </div>
            <h2 style="margin: 0 0 5px;">Pengaturan Akun</h2>
            <p style="margin: 0; opacity: 0.8; font-size: 14px;">Kelola identitas dan keamanan akun FNM TV Anda</p>
        </div>

        <div style="padding: 40px;">
            <form id="formEditProfil" onsubmit="event.preventDefault(); simpanProfil();">

                <h3 style="font-size: 16px; margin-bottom: 20px; color: var(--text);"><i class="fas fa-id-card" style="color: var(--muted); margin-right: 8px;"></i> Informasi Dasar</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                    <div class="field">
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--muted); margin-bottom: 8px;">Username</label>
                        <div style="position: relative;">
                            <i class="fas fa-at" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                            <input type="text" id="inputUsername" placeholder="Username Anda" value="{{ Auth::user()->username }}" style="width: 100%; padding: 12px 15px 12px 40px; border: 1px solid var(--border); border-radius: 8px; outline: none; font-family: inherit;">
                        </div>
                    </div>

                    <div class="field">
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--muted); margin-bottom: 8px;">Alamat Email</label>
                        <div style="position: relative;">
                            <i class="fas fa-envelope" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                            <input type="email" id="inputEmail" placeholder="Email Anda" value="{{ Auth::user()->email }}" style="width: 100%; padding: 12px 15px 12px 40px; border: 1px solid var(--border); border-radius: 8px; outline: none; font-family: inherit;">
                        </div>
                    </div>
                </div>

                <hr style="border: none; border-top: 1px dashed var(--border); margin: 30px 0;">

                <h3 style="font-size: 16px; margin-bottom: 20px; color: var(--text);"><i class="fas fa-lock" style="color: var(--muted); margin-right: 8px;"></i> Keamanan & Password</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
                    <div class="field">
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--muted); margin-bottom: 8px;">Password Baru</label>
                        <div style="position: relative;">
                            <i class="fas fa-key" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                            <input type="password" id="inputPassword" placeholder="Kosongkan jika tidak diubah" style="width: 100%; padding: 12px 15px 12px 40px; border: 1px solid var(--border); border-radius: 8px; outline: none; font-family: inherit;">
                        </div>
                    </div>

                    <div class="field">
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--muted); margin-bottom: 8px;">Konfirmasi Password Baru</label>
                        <div style="position: relative;">
                            <i class="fas fa-check-circle" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                            <input type="password" id="inputConfirmPassword" placeholder="Ulangi password baru" style="width: 100%; padding: 12px 15px 12px 40px; border: 1px solid var(--border); border-radius: 8px; outline: none; font-family: inherit;">
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 15px;">
                    <button type="button" class="btn btn-outline" style="padding: 12px 24px; border-radius: 8px;" onclick="window.history.back()">Kembali</button>
                    <button type="submit" class="btn btn-red" id="btnSimpanProfil" style="padding: 12px 24px; border-radius: 8px;">
                        <i class="fas fa-save" style="margin-right: 5px;"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Fungsi Dummy buat pamer UI ke dosen/temen sebelum backend jadi wkwk
    function simpanProfil() {
        const btn = document.getElementById('btnSimpanProfil');
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;

        setTimeout(() => {
            Toast.show('success', 'Mantap! Profil anda berhasil diupdate.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 1500); // Muter 1.5 detik biar realistis
    }
</script>
@endsection
