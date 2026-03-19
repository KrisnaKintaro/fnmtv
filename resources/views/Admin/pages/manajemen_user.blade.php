@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
  <!-- ══ PAGE: USERS ══ -->
  <div id="page-users" class="page active">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
      <div class="section-title" style="margin:0">Manajemen User</div>
      <button class="btn btn-red">+ Tambah User</button>
    </div>
    <div class="card">
      <table>
        <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Artikel</th><th>Bergabung</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          <tr><td><div class="user-row"><div class="u-av">A</div><b>Admin FNM</b></div></td><td style="font-size:12px;color:var(--muted)">admin@fnm.id</td><td><span class="badge b-cat">Super Admin</span></td><td>—</td><td style="font-size:12px;color:var(--muted)">1 Jan 2024</td><td><span class="badge b-pub">Aktif</span></td><td><div class="act-btns"><div class="ico-btn">✏️</div></div></td></tr>
          <tr><td><div class="user-row"><div class="u-av" style="background:#1a3a7a">B</div><b>Budi Santoso</b></div></td><td style="font-size:12px;color:var(--muted)">budi@fnm.id</td><td><span class="badge b-review">Editor</span></td><td>84</td><td style="font-size:12px;color:var(--muted)">15 Mar 2024</td><td><span class="badge b-pub">Aktif</span></td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></td></tr>
          <tr><td><div class="user-row"><div class="u-av" style="background:var(--success)">R</div><b>Rina Agustina</b></div></td><td style="font-size:12px;color:var(--muted)">rina@fnm.id</td><td><span class="badge b-review">Penulis</span></td><td>55</td><td style="font-size:12px;color:var(--muted)">20 Apr 2024</td><td><span class="badge b-pub">Aktif</span></td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></td></tr>
          <tr><td><div class="user-row"><div class="u-av" style="background:var(--warning)">D</div><b>Dewi Puspita</b></div></td><td style="font-size:12px;color:var(--muted)">dewi@fnm.id</td><td><span class="badge b-review">Penulis</span></td><td>22</td><td style="font-size:12px;color:var(--muted)">5 Jun 2024</td><td><span class="badge b-draft">Nonaktif</span></td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></td></tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('js')
@endsection
