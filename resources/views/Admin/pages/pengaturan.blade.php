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

  <form method="POST" action="{{ url('/pengaturan/password') }}">
    @csrf
    <div class="form-card">
      <div class="form-title">Ganti Password Admin</div>

      @if(session('success'))
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Toast.show('success', @json(session('success')));
          });
      </script>
      @endif

      @if($errors->any())
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Toast.show('error', @json($errors->first()));
          });
      </script>
      @endif

      {{-- Password Lama --}}
      <div class="field">
        <label>Password Lama</label>
        <div style="position: relative;">
            <i class="fas fa-lock" style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--muted); pointer-events:none;"></i>
            <input type="password" name="password_lama" required
                style="width:100%; padding:10px 40px 10px 40px; border:1.5px solid var(--border); border-radius:6px; outline:none; font-size:13px;">
            <i class="fas fa-eye toggle-password" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:var(--muted); z-index:9999; pointer-events:auto;"></i>
        </div>
      </div>

      {{-- Password Baru --}}
      <div class="field">
        <label>Password Baru</label>
        <div style="position: relative;">
            <i class="fas fa-key" style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--muted); pointer-events:none;"></i>
            <input type="password" name="password_baru" required
                style="width:100%; padding:10px 40px 10px 40px; border:1.5px solid var(--border); border-radius:6px; outline:none; font-size:13px;">
            <i class="fas fa-eye toggle-password" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:var(--muted); z-index:9999; pointer-events:auto;"></i>
        </div>
      </div>

      {{-- Konfirmasi Password Baru --}}
      <div class="field">
        <label>Konfirmasi Password Baru</label>
        <div style="position: relative;">
            <i class="fas fa-check-circle" style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--muted); pointer-events:none;"></i>
            <input type="password" name="password_baru_confirmation" required
                style="width:100%; padding:10px 40px 10px 40px; border:1.5px solid var(--border); border-radius:6px; outline:none; font-size:13px;">
            <i class="fas fa-eye toggle-password" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:var(--muted); z-index:9999; pointer-events:auto;"></i>
        </div>
      </div>

      <button class="btn btn-red" type="submit">Update Password</button>  {{-- ← JANGAN LUPA INI --}}
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