@extends('Admin.master_admin')
@section('css')
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

      <div class="field">
        <label>Password Lama</label>
        <input type="password" name="password_lama" required>
        @error('password_lama')
          <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror
      </div>
      <div class="field">
        <label>Password Baru</label>
        <input type="password" name="password_baru" required>
        @error('password_baru')
          <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror
      </div>
      <div class="field">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="password_baru_confirmation" required>
        @error('password_baru_confirmation')
          <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror
      </div>
      <button class="btn btn-red" type="submit">Update Password</button>
    </div>
  </form>
@endsection
@section('js')
@endsection
