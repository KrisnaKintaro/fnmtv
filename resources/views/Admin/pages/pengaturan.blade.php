@extends('Admin.master_admin')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
@section('konten')
  <!-- ══ PAGE: SETTINGS ══ -->
  <form method="POST" action="{{ url('/pengaturan') }}">
    @csrf
    <div class="form-card">
      <div class="form-title">Identitas Situs</div>
      <div class="field">
        <label>Nama Situs</label>
        <input type="text" name="nama_situs" value="{{ old('nama_situs', $settings['nama_situs'] ?? 'Fenomena News Media') }}">
      </div>
      <div class="field">
        <label>Tagline</label>
        <input type="text" name="tagline" value="{{ old('tagline', $settings['tagline'] ?? 'Delivering unbiased, in-depth reporting') }}">
      </div>
      <div class="field">
        <label>URL Situs</label>
        <input type="text" name="url_situs" value="{{ $settings['url_situs'] ?? '' }}" readonly class="form-control" />
      </div>
      <button class="btn btn-red" type="submit">Simpan Perubahan</button>
    </div>
  </form>


  <form method="POST" action="{{ url('/pengaturan/profil') }}">
      @csrf
      
      <div class="card profile-card">

          <div class="card-hd">
              <div class="card-ht">Profil Admin</div>
              <div class="card-hm">
                  Kelola identitas dan keamanan akun Anda
              </div>
          </div>

          <div class="profile-body">

              {{-- INFORMASI DASAR --}}
              <div class="profile-section">

                  <div class="profile-section-title">
                      <h3>Informasi Dasar</h3>
                  </div>

                  <div class="profile-grid">

                      {{-- Username --}}
                      <div class="field">
                          <label>Username</label>

                          <div class="profile-input-wrap">
                              <i class="fas fa-user"></i>

                              <input
                                  type="text"
                                  name="username"
                                  value="{{ Auth::user()->username }}"
                                  class="profile-input"
                              >
                          </div>
                      </div>

                      {{-- Email --}}
                      <div class="field">
                          <label>Email</label>

                          <div class="profile-input-wrap">
                              <i class="fas fa-envelope"></i>

                              <input
                                  type="email"
                                  name="email"
                                  value="{{ Auth::user()->email }}"
                                  class="profile-input"
                              >
                          </div>
                      </div>

                  </div>
              </div>

              {{-- PASSWORD --}}
              <div class="profile-section">

                  <div class="profile-section-title">
                      <h3>Keamanan & Password</h3>
                      <span>Kosongkan jika tidak diubah</span>
                  </div>

                  {{-- Password Lama --}}
                  <div class="field">
                      <label>Password Lama</label>

                      <div class="profile-input-wrap">
                          <i class="fas fa-lock"></i>

                          <input
                              type="password"
                              name="password_lama"
                              placeholder="Masukkan password lama"
                              class="profile-input"
                          >

                          <i class="fas fa-eye toggle-password"></i>
                      </div>
                  </div>

                  <div class="profile-grid">

                      {{-- Password Baru --}}
                      <div class="field">
                          <label>Password Baru</label>

                          <div class="profile-input-wrap">
                              <i class="fas fa-key"></i>

                              <input
                                  type="password"
                                  name="password_baru"
                                  placeholder="Minimal 8 karakter"
                                  class="profile-input"
                              >

                              <i class="fas fa-eye toggle-password"></i>
                          </div>
                      </div>

                      {{-- Konfirmasi --}}
                      <div class="field">
                          <label>Konfirmasi Password Baru</label>

                          <div class="profile-input-wrap">
                              <i class="fas fa-check-circle"></i>

                              <input
                                  type="password"
                                  name="password_baru_confirmation"
                                  placeholder="Ulangi password baru"
                                  class="profile-input"
                              >

                              <i class="fas fa-eye toggle-password"></i>
                          </div>
                      </div>

                  </div>
              </div>

              <button class="btn btn-red" type="submit">
                  Simpan Perubahan
              </button>

          </div>
      </div>
  </form>
@endsection

@section('js')
<script>
    $(document).on('click', '.toggle-password', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).toggleClass('fa-eye fa-eye-slash');
        
        const input = $(this).closest('div').find('input');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });
</script>
@endsection