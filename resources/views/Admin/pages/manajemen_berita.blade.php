@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
      <!-- ══ PAGE: NEWS LIST (UC-02, UC-04) ══ -->
  <div id="page-news-list" class="page active">
    <div class="section-title">Manajemen Berita</div>
    <div class="filter-bar">
      <div class="tab-pills">
        <div class="tab-p active">Semua (247)</div>
        <div class="tab-p">Terbit (198)</div>
        <div class="tab-p">Draft (34)</div>
        <div class="tab-p">Review (15)</div>
      </div>
      <select class="filter-select"><option>Semua Kategori</option><option>Politik</option><option>Ekonomi</option><option>Olahraga</option><option>Teknologi</option><option>Kesehatan</option></select>
      <select class="filter-select"><option>Semua Penulis</option><option>Budi Santoso</option><option>Rina Agustina</option><option>Arif Wibowo</option></select>
      <button class="btn btn-red btn-sm" style="margin-left:auto;" onclick="showPage('write-news',null)">+ Tulis Berita Baru</button>
    </div>
    <div class="card">
      <table>
        <thead><tr><th>Judul Berita</th><th>Kategori</th><th>Penulis</th><th>Status Publikasi</th><th>Views</th><th>Tgl Terbit</th><th>Aksi</th></tr></thead>
        <tbody>
          <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="tbl-img">🏛️</div><div><div class="tbl-title">Pemerintah Umumkan Kebijakan Ekonomi Baru untuk 2026</div><div class="tbl-meta">slug: pemerintah-kebijakan-2026</div></div></div></td><td><span class="badge b-cat">Politik</span></td><td style="font-size:12px;color:var(--muted)">Budi S.</td><td><span class="badge b-pub">● Published</span></td><td style="font-family:'JetBrains Mono';font-size:12px">12.4K</td><td style="font-size:12px;color:var(--muted)">10 Mar 2026</td><td><div class="act-btns"><div class="ico-btn" title="Edit">✏️</div><div class="ico-btn" title="Preview">👁</div><div class="ico-btn" title="Ubah Status">🔄</div><div class="ico-btn" title="Hapus">🗑</div></div></td></tr>
          <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="tbl-img">⚽</div><div><div class="tbl-title">Timnas Garuda Menang Telak 3-0 Lawan Vietnam</div><div class="tbl-meta">slug: timnas-menang-3-0</div></div></div></td><td><span class="badge b-cat">Olahraga</span></td><td style="font-size:12px;color:var(--muted)">Rina A.</td><td><span class="badge b-pub">● Published</span></td><td style="font-family:'JetBrains Mono';font-size:12px">28.7K</td><td style="font-size:12px;color:var(--muted)">10 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">👁</div><div class="ico-btn">🔄</div><div class="ico-btn">🗑</div></div></td></tr>
          <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="tbl-img">💹</div><div><div class="tbl-title">IHSG Menguat Tipis di Sesi Pagi Perdagangan</div><div class="tbl-meta">slug: ihsg-menguat-tipis</div></div></div></td><td><span class="badge b-cat">Ekonomi</span></td><td style="font-size:12px;color:var(--muted)">Arif W.</td><td><span class="badge b-draft">○ Draft</span></td><td style="font-family:'JetBrains Mono';font-size:12px">—</td><td style="font-size:12px;color:var(--muted)">—</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">👁</div><div class="ico-btn">🔄</div><div class="ico-btn">🗑</div></div></td></tr>
          <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="tbl-img">🔬</div><div><div class="tbl-title">Peneliti BRIN Temukan Spesies Baru di Papua</div><div class="tbl-meta">slug: brin-spesies-baru-papua</div></div></div></td><td><span class="badge b-cat">Sains</span></td><td style="font-size:12px;color:var(--muted)">Dewi P.</td><td><span class="badge b-review">◐ Review</span></td><td style="font-family:'JetBrains Mono';font-size:12px">—</td><td style="font-size:12px;color:var(--muted)">—</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">👁</div><div class="ico-btn">🔄</div><div class="ico-btn">🗑</div></div></td></tr>
          <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="tbl-img">🎬</div><div><div class="tbl-title">Film Indonesia Raih Penghargaan di Festival Berlin</div><div class="tbl-meta">slug: film-indonesia-berlin</div></div></div></td><td><span class="badge b-cat">Hiburan</span></td><td style="font-size:12px;color:var(--muted)">Sari M.</td><td><span class="badge b-pub">● Published</span></td><td style="font-family:'JetBrains Mono';font-size:12px">9.2K</td><td style="font-size:12px;color:var(--muted)">9 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">👁</div><div class="ico-btn">🔄</div><div class="ico-btn">🗑</div></div></td></tr>
        </tbody>
      </table>
      <div class="pager">
        <div class="pg-btn">‹</div><div class="pg-btn active">1</div><div class="pg-btn">2</div><div class="pg-btn">3</div><div class="pg-btn">...</div><div class="pg-btn">25</div><div class="pg-btn">›</div>
        <div class="pg-info">1–5 dari 247 berita</div>
      </div>
    </div>
  </div>
@endsection
@section('js')
@endsection
