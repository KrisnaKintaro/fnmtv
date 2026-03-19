@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
  <!-- ══ PAGE: SETTINGS ══ -->
  <div id="page-settings" class="page active">
    <div class="section-title">Pengaturan Sistem</div>
    <div style="max-width:600px;">
      <div class="form-card" style="margin-bottom:16px;">
        <div class="form-title">Identitas Situs</div>
        <div class="field"><label>Nama Situs</label><input type="text" value="Fenomena News Media"></div>
        <div class="field"><label>Tagline</label><input type="text" value="Delivering unbiased, in-depth reporting"></div>
        <div class="field"><label>URL Situs</label><input type="text" value="https://fnm.id"></div>
        <button class="btn btn-red">Simpan Perubahan</button>
      </div>
      <div class="form-card" style="margin-bottom:16px;">
        <div class="form-title">Ganti Password Admin</div>
        <div class="field"><label>Password Lama</label><input type="password"></div>
        <div class="field"><label>Password Baru</label><input type="password"></div>
        <div class="field"><label>Konfirmasi Password Baru</label><input type="password"></div>
        <button class="btn btn-red">Update Password</button>
      </div>
    </div>
  </div>
@endsection
@section('js')
@endsection
