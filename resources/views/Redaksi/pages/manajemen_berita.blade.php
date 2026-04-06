@extends('Redaksi.redaksi_master')

@section('css')
@endsection

@section('konten')
<!-- ══ HALAMAN MANAJEMEN BERITA ══ -->
  <div class="page">
    <div class="section-title">Manajemen Berita</div>

    <!-- Filter Tab -->
    <div class="filter-bar">
      <div class="tab-pills" id="tabPills">
        <div class="tab-p active" onclick="filterTab(this,'all')">
          Semua <span class="tab-cnt cnt-all" id="cnt-all">9</span>
        </div>
        <div class="tab-p" onclick="filterTab(this,'pending')">
          Pending <span class="tab-cnt cnt-pending" id="cnt-pending">5</span>
        </div>
        <div class="tab-p" onclick="filterTab(this,'approved')">
          Disetujui <span class="tab-cnt cnt-approved" id="cnt-approved">3</span>
        </div>
        <div class="tab-p" onclick="filterTab(this,'rejected')">
          Ditolak <span class="tab-cnt cnt-rejected" id="cnt-rejected">1</span>
        </div>
      </div>
      <div style="margin-left:auto;display:flex;gap:8px;">
        <select class="filter-select" style="font-size:12px;padding:6px 10px;">
          <option>Semua Kategori</option>
          <option>Politik</option><option>Ekonomi</option><option>Teknologi</option>
          <option>Olahraga</option><option>Kesehatan</option><option>Internasional</option>
        </select>
        <select class="filter-select" style="font-size:12px;padding:6px 10px;">
          <option>Semua Penulis</option>
          <option>Budi Santoso</option><option>Arif Wibowo</option>
          <option>Dewi Puspita</option><option>Sari Maharani</option>
        </select>
      </div>
    </div>

    <div class="card">
      <div class="card-hd">
        <div class="card-ht">Daftar Artikel Masuk dari Editor</div>
        <div class="card-hm" id="tableCount">Menampilkan 9 artikel</div>
      </div>

      <table>
        <thead>
          <tr>
            <th style="width:70px;">Thumbnail</th>
            <th>Judul &amp; Informasi</th>
            <th>Kategori</th>
            <th>Penulis</th>
            <th>Tanggal Kirim</th>
            <th>Status</th>
            <th style="width:80px;text-align:center;">Aksi</th>
          </tr>
        </thead>
        <tbody id="newsBody">

          <!-- ═══ PENDING (5 baris) ═══ -->
          <tr data-status="pending" data-key="beras">
            <td><div class="tbl-img">🌾</div></td>
            <td>
              <div class="tbl-title">Harga Beras Naik Jelang Lebaran, Pemerintah Buka Impor</div>
              <div class="tbl-meta">Menunggu keputusan Redaksi</div>
            </td>
            <td><span class="badge b-cat">Ekonomi</span></td>
            <td style="font-size:12px;color:var(--muted);">Budi Santoso</td>
            <td style="font-size:12px;color:var(--muted);">26 Mar 2026</td>
            <td><span class="badge b-pending">Pending</span></td>
            <td>
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('beras')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <tr data-status="pending" data-key="bpjs">
            <td><div class="tbl-img">🏥</div></td>
            <td>
              <div class="tbl-title">BPJS Kesehatan Tanggung Biaya Operasi Jantung Terbaru</div>
              <div class="tbl-meta">Menunggu keputusan Redaksi</div>
            </td>
            <td><span class="badge b-cat">Kesehatan</span></td>
            <td style="font-size:12px;color:var(--muted);">Arif Wibowo</td>
            <td style="font-size:12px;color:var(--muted);">25 Mar 2026</td>
            <td><span class="badge b-pending">Pending</span></td>
            <td>
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('bpjs')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <tr data-status="pending" data-key="asean">
            <td><div class="tbl-img">🌐</div></td>
            <td>
              <div class="tbl-title">KTT ASEAN 2026 Bahas Krisis Pangan dan Energi Regional</div>
              <div class="tbl-meta">Menunggu keputusan Redaksi</div>
            </td>
            <td><span class="badge b-cat">Internasional</span></td>
            <td style="font-size:12px;color:var(--muted);">Budi Santoso</td>
            <td style="font-size:12px;color:var(--muted);">24 Mar 2026</td>
            <td><span class="badge b-pending">Pending</span></td>
            <td>
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('asean')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <tr data-status="pending" data-key="brin">
            <td><div class="tbl-img">🔬</div></td>
            <td>
              <div class="tbl-title">Peneliti BRIN Temukan Spesies Baru di Hutan Papua</div>
              <div class="tbl-meta">Menunggu keputusan Redaksi</div>
            </td>
            <td><span class="badge b-cat">Sains</span></td>
            <td style="font-size:12px;color:var(--muted);">Dewi Puspita</td>
            <td style="font-size:12px;color:var(--muted);">23 Mar 2026</td>
            <td><span class="badge b-pending">Pending</span></td>
            <td>
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('brin')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <tr data-status="pending" data-key="lrt">
            <td><div class="tbl-img">🏙️</div></td>
            <td>
              <div class="tbl-title">Proyek LRT Jabodebek Fase 2 Mulai Konstruksi April 2026</div>
              <div class="tbl-meta">Menunggu keputusan Redaksi</div>
            </td>
            <td><span class="badge b-cat">Infrastruktur</span></td>
            <td style="font-size:12px;color:var(--muted);">Arif Wibowo</td>
            <td style="font-size:12px;color:var(--muted);">22 Mar 2026</td>
            <td><span class="badge b-pending">Pending</span></td>
            <td style="text-align:center;">
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('lrt')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <!-- ═══ DISETUJUI (3 baris) ═══ -->
          <tr data-status="approved" data-key="kebijakan">
            <td><div class="tbl-img">🏛️</div></td>
            <td>
              <div class="tbl-title">Pemerintah Umumkan Kebijakan Ekonomi Baru untuk 2026</div>
              <div class="tbl-meta">Disetujui oleh Redaksi</div>
            </td>
            <td><span class="badge b-cat">Politik</span></td>
            <td style="font-size:12px;color:var(--muted);">Budi Santoso</td>
            <td style="font-size:12px;color:var(--muted);">15 Mar 2026</td>
            <td><span class="badge b-approved">Disetujui</span></td>
            <td style="text-align:center;">
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('kebijakan')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <tr data-status="approved" data-key="garuda">
            <td><div class="tbl-img">⚽</div></td>
            <td>
              <div class="tbl-title">Timnas Garuda Menang Telak 3-0 Lawan Vietnam</div>
              <div class="tbl-meta">Disetujui oleh Redaksi</div>
            </td>
            <td><span class="badge b-cat">Olahraga</span></td>
            <td style="font-size:12px;color:var(--muted);">Sari Maharani</td>
            <td style="font-size:12px;color:var(--muted);">14 Mar 2026</td>
            <td><span class="badge b-approved">Disetujui</span></td>
            <td style="text-align:center;">
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('garuda')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <tr data-status="approved" data-key="film">
            <td><div class="tbl-img">🎬</div></td>
            <td>
              <div class="tbl-title">Film Indonesia Raih Penghargaan di Festival Berlin</div>
              <div class="tbl-meta">Disetujui oleh Redaksi</div>
            </td>
            <td><span class="badge b-cat">Hiburan</span></td>
            <td style="font-size:12px;color:var(--muted);">Dewi Puspita</td>
            <td style="font-size:12px;color:var(--muted);">12 Mar 2026</td>
            <td><span class="badge b-approved">Disetujui</span></td>
            <td style="text-align:center;">
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('film')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

          <!-- ═══ DITOLAK (1 baris) ═══ -->
          <tr data-status="rejected" data-key="rupiah">
            <td><div class="tbl-img">📉</div></td>
            <td>
              <div class="tbl-title">Rupiah Melemah ke Level Rp 16.800 Per Dolar AS</div>
              <div class="tbl-meta">Dikembalikan ke Editor untuk revisi</div>
            </td>
            <td><span class="badge b-cat">Ekonomi</span></td>
            <td style="font-size:12px;color:var(--muted);">Budi Santoso</td>
            <td style="font-size:12px;color:var(--muted);">10 Mar 2026</td>
            <td><span class="badge b-rejected">Ditolak</span></td>
            <td style="text-align:center;">
              <div class="act-btns" style="justify-content:center;">
                <div class="ico-btn" title="Lihat Artikel" onclick="openModal('rupiah')">
                  <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
              </div>
            </td>
          </tr>

        </tbody>
      </table>

      <div class="pager">
        <div class="pg-btn active">1</div>
        <div class="pg-info" id="pagerInfo">Menampilkan 9 dari 9 artikel</div>
      </div>
    </div>
  </div><!-- /page -->
@endsection

