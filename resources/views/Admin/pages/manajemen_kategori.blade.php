@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
  <!-- ══ PAGE: CATEGORIES (UC-03) ══ -->
  <div id="page-categories" class="page active">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
      <div class="section-title" style="margin:0;">Manajemen Kategori</div>
      <button class="btn btn-red" onclick="document.getElementById('modalCat').classList.add('open')">+ Tambah Kategori</button>
    </div>
    <div class="cat-grid">
      <div class="cat-chip"><div><div class="cat-name">🏛️ Politik</div><div class="cat-count">84 artikel</div></div><div class="cat-actions"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></div>
      <div class="cat-chip"><div><div class="cat-name">💹 Ekonomi</div><div class="cat-count">62 artikel</div></div><div class="cat-actions"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></div>
      <div class="cat-chip"><div><div class="cat-name">⚽ Olahraga</div><div class="cat-count">55 artikel</div></div><div class="cat-actions"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></div>
      <div class="cat-chip"><div><div class="cat-name">💻 Teknologi</div><div class="cat-count">43 artikel</div></div><div class="cat-actions"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></div>
      <div class="cat-chip"><div><div class="cat-name">🩺 Kesehatan</div><div class="cat-count">31 artikel</div></div><div class="cat-actions"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></div>
      <div class="cat-chip"><div><div class="cat-name">🎬 Hiburan</div><div class="cat-count">28 artikel</div></div><div class="cat-actions"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></div>
      <div class="cat-chip"><div><div class="cat-name">🔬 Sains</div><div class="cat-count">22 artikel</div></div><div class="cat-actions"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></div>
      <div class="cat-chip" style="border-style:dashed;cursor:pointer;justify-content:center;color:var(--muted);" onclick="document.getElementById('modalCat').classList.add('open')">
        <div style="text-align:center"><div style="font-size:22px;">+</div><div style="font-size:12px;">Tambah Kategori</div></div>
      </div>
    </div>
    <div class="card">
      <div class="card-hd"><div class="card-ht">Semua Kategori & Detail</div></div>
      <table>
        <thead><tr><th>Nama Kategori</th><th>Slug</th><th>Jumlah Artikel</th><th>Terakhir Diupdate</th><th>Aksi</th></tr></thead>
        <tbody>
          <tr><td><b>🏛️ Politik</b></td><td style="font-family:'JetBrains Mono';font-size:12px;color:var(--muted)">politik</td><td>84</td><td style="color:var(--muted);font-size:12px">10 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></td></tr>
          <tr><td><b>💹 Ekonomi</b></td><td style="font-family:'JetBrains Mono';font-size:12px;color:var(--muted)">ekonomi</td><td>62</td><td style="color:var(--muted);font-size:12px">9 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></td></tr>
          <tr><td><b>⚽ Olahraga</b></td><td style="font-family:'JetBrains Mono';font-size:12px;color:var(--muted)">olahraga</td><td>55</td><td style="color:var(--muted);font-size:12px">8 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🗑</div></div></td></tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('js')
@endsection
