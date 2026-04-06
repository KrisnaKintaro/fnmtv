@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
  <!-- ══ HALAMAN MANAJEMEN BERITA ══════════ -->
  <div class="page active">
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
            <th style="width:64px;text-align:center;">Aksi</th>
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
            <td>
              <select class="status-select" onchange="handleChange(this)">
                <option value="pending" selected>◐ Pending</option>
                <option value="approved">● Disetujui</option>
                <option value="rejected">✕ Ditolak</option>
              </select>
            </td>
            <td style="text-align:center;">
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
            <td>
              <select class="status-select" onchange="handleChange(this)">
                <option value="pending" selected>◐ Pending</option>
                <option value="approved">● Disetujui</option>
                <option value="rejected">✕ Ditolak</option>
              </select>
            </td>
            <td style="text-align:center;">
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
            <td>
              <select class="status-select" onchange="handleChange(this)">
                <option value="pending" selected>◐ Pending</option>
                <option value="approved">● Disetujui</option>
                <option value="rejected">✕ Ditolak</option>
              </select>
            </td>
            <td style="text-align:center;">
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
            <td>
              <select class="status-select" onchange="handleChange(this)">
                <option value="pending" selected>◐ Pending</option>
                <option value="approved">● Disetujui</option>
                <option value="rejected">✕ Ditolak</option>
              </select>
            </td>
            <td style="text-align:center;">
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
            <td>
              <select class="status-select" onchange="handleChange(this)">
                <option value="pending" selected>◐ Pending</option>
                <option value="approved">● Disetujui</option>
                <option value="rejected">✕ Ditolak</option>
              </select>
            </td>
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
            <td><span class="badge b-approved">● Disetujui</span></td>
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
            <td><span class="badge b-approved">● Disetujui</span></td>
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
            <td><span class="badge b-approved">● Disetujui</span></td>
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
            <td><span class="badge b-rejected">✕ Ditolak</span></td>
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


<!-- ══════════ MODAL: KONFIRMASI STATUS ══════════ -->
<div class="modal-backdrop" id="modalConfirm">
  <div class="modal" style="max-width:480px;">
    <div class="modal-hd">
      <div class="modal-hd-text">
        <div class="modal-title" id="mcTitle">Konfirmasi Keputusan</div>
        <div class="modal-sub" id="mcSub">—</div>
      </div>
      <div class="modal-close" onclick="cancelConfirm()">✕</div>
    </div>
    <div class="modal-body" style="padding:24px 26px;">
      <!-- Approve -->
      <div id="mcApproveSection">
        <p style="font-size:14px;line-height:1.6;color:var(--text);margin-bottom:20px;">
          Artikel ini akan ditandai sebagai <strong>Disetujui</strong> dan siap untuk diterbitkan. Pastikan Anda sudah membaca dan memverifikasi isi artikel sebelum melanjutkan.
        </p>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
          <button class="btn btn-outline btn-sm" onclick="cancelConfirm()">Batal</button>
          <button class="btn btn-sm" style="background:var(--success);color:#fff;" onclick="finalizeApprove()">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            Ya, Setujui Artikel
          </button>
        </div>
      </div>
      <!-- Reject -->
      <div id="mcRejectSection" style="display:none;">
        <p style="font-size:14px;line-height:1.6;color:var(--text);margin-bottom:16px;">
          Artikel akan dikembalikan ke Editor dengan catatan alasan penolakan di bawah ini.
        </p>
        <div class="reject-note show" style="margin-top:0;">
          <label>Alasan Penolakan untuk Editor *</label>
          <textarea id="rejectNoteText" placeholder="Jelaskan bagian yang perlu diperbaiki oleh Editor..."></textarea>
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:12px;">
          <button class="btn btn-outline btn-sm" onclick="cancelConfirm()">Batal</button>
          <button class="btn btn-red btn-sm" onclick="finalizeReject()">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            Tolak &amp; Kembalikan ke Editor
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══════════ MODAL: DETAIL ARTIKEL ══════════ -->
<div class="modal-backdrop" id="modalDetail">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-hd-text">
        <div class="modal-title" id="mdTitle">—</div>
        <div class="modal-sub" id="mdSub">—</div>
      </div>
      <div class="modal-close" onclick="closeDetail()">✕</div>
    </div>
    <div class="modal-body">
      <div class="modal-thumb" id="mdEmoji">🗞️</div>
      <div class="modal-chips">
        <div class="chip">Penulis: <b id="md-author">—</b></div>
        <div class="chip">Kategori: <b id="md-cat">—</b></div>
        <div class="chip">Dikirim: <b id="md-date">—</b></div>
        <div class="chip">Status: <b id="md-status">—</b></div>
      </div>
      <div class="modal-sec">Konten Artikel</div>
      <div class="modal-article-body" id="mdContent">—</div>

      <!-- Kotak keputusan — hanya tampil bila pending -->
      <div id="mdVerdictWrap">
        <div class="modal-divider"></div>
        <div class="verdict-box">
          <div class="verdict-title">Keputusan Verifikasi</div>
          <div class="verdict-desc">Tinjau artikel di atas lalu tentukan kelayakan penerbitannya.</div>
          <div class="verdict-actions">
            <button class="vbtn vbtn-approve" onclick="verdictApprove()">
              <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              Setujui Artikel
            </button>
            <button class="vbtn vbtn-reject" onclick="verdictReject()">
              <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
              Tolak &amp; Kembalikan
            </button>
          </div>
          <div class="reject-note" id="mdRejectNote">
            <label>Alasan Penolakan untuk Editor *</label>
            <textarea id="mdRejectText" placeholder="Jelaskan bagian yang perlu diperbaiki oleh Editor..."></textarea>
            <div class="reject-note-btns">
              <button class="btn btn-outline btn-sm" onclick="closeRejectNote()">Batal</button>
              <button class="btn btn-red btn-sm" onclick="submitRejectFromDetail()">Kirim Penolakan</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
@section('js')
<script>
/* ─── DATA ARTIKEL ─── */
const DB = {
  beras:    { emoji:'🌾', title:'Harga Beras Naik Jelang Lebaran, Pemerintah Buka Impor',           author:'Budi Santoso',  cat:'Ekonomi',       date:'26 Mar 2026', status:'pending',  content:'<p>Jakarta, FNM — Pemerintah Indonesia mengumumkan kebijakan impor beras darurat menyusul kenaikan harga komoditas pangan yang melampaui Harga Eceran Tertinggi (HET) di sejumlah daerah menjelang Hari Raya Idul Fitri.</p><p>Menteri Perdagangan dalam konferensi pers Senin pagi menyatakan langkah impor diambil untuk menstabilkan pasokan. Sebanyak 500.000 ton beras dijadwalkan tiba pertengahan April 2026.</p><p>Kenaikan harga tercatat rata-rata 18 persen dibanding bulan lalu, dengan lonjakan tertinggi di Sumatra Utara dan Kalimantan Timur.</p>'},
  bpjs:     { emoji:'🏥', title:'BPJS Kesehatan Tanggung Biaya Operasi Jantung Terbaru',            author:'Arif Wibowo',   cat:'Kesehatan',     date:'25 Mar 2026', status:'pending',  content:'<p>Jakarta, FNM — BPJS Kesehatan resmi memasukkan prosedur bedah jantung terbuka dengan teknologi minimal invasif ke dalam daftar layanan yang dijamin mulai 1 April 2026.</p><p>Direktur Utama BPJS Kesehatan menyampaikan bahwa perluasan cakupan ini merupakan hasil evaluasi klaim tiga tahun terakhir. Diperkirakan lebih dari 120.000 peserta akan menerima manfaat ini setiap tahunnya.</p>'},
  asean:    { emoji:'🌐', title:'KTT ASEAN 2026 Bahas Krisis Pangan dan Energi Regional',           author:'Budi Santoso',  cat:'Internasional', date:'24 Mar 2026', status:'pending',  content:'<p>Kuala Lumpur, FNM — Para pemimpin negara ASEAN berkumpul dalam KTT tahunan di Kuala Lumpur membahas dua isu krusial: ketahanan pangan dan krisis energi kawasan.</p><p>Presiden Indonesia menegaskan komitmen menjadi penyuplai surplus pangan ASEAN. Delegasi Thailand mengusulkan dana bersama USD 2 miliar untuk ketahanan energi terbarukan.</p>'},
  brin:     { emoji:'🔬', title:'Peneliti BRIN Temukan Spesies Baru di Hutan Papua',                author:'Dewi Puspita',  cat:'Sains',         date:'23 Mar 2026', status:'pending',  content:'<p>Jakarta, FNM — Tim peneliti BRIN mengumumkan penemuan dua spesies baru fauna di hutan hujan Papua Barat yang belum pernah diidentifikasi sebelumnya.</p><p>Spesies tersebut adalah katak pohon biru cerah (<em>Litoria papuensis fluorescens</em>) dan serangga Phasmatodea raksasa. Temuan dipublikasikan di jurnal Zootaxa.</p>'},
  lrt:      { emoji:'🏙️', title:'Proyek LRT Jabodebek Fase 2 Mulai Konstruksi April 2026',         author:'Arif Wibowo',   cat:'Infrastruktur', date:'22 Mar 2026', status:'pending',  content:'<p>Jakarta, FNM — Kementerian Perhubungan mengumumkan pembangunan LRT Jabodebek Fase 2 menuju Tangerang Selatan dan Bekasi Timur dimulai April 2026.</p><p>Anggaran Rp 18,7 triliun telah disetujui DPR dan akan didanai melalui APBN serta pinjaman lunak dari Asian Development Bank (ADB).</p>'},
  kebijakan:{ emoji:'🏛️', title:'Pemerintah Umumkan Kebijakan Ekonomi Baru untuk 2026',            author:'Budi Santoso',  cat:'Politik',       date:'15 Mar 2026', status:'approved', content:'<p>Jakarta, FNM — Presiden Republik Indonesia meresmikan paket kebijakan ekonomi komprehensif 2026 yang mencakup stimulus fiskal, deregulasi investasi, dan perluasan program perlindungan sosial.</p>'},
  garuda:   { emoji:'⚽', title:'Timnas Garuda Menang Telak 3-0 Lawan Vietnam',                    author:'Sari Maharani', cat:'Olahraga',      date:'14 Mar 2026', status:'approved', content:'<p>Jakarta, FNM — Timnas Indonesia mempersembahkan kemenangan 3-0 atas Vietnam dalam laga uji coba internasional di Stadion Gelora Bung Karno, Jakarta.</p>'},
  film:     { emoji:'🎬', title:'Film Indonesia Raih Penghargaan di Festival Berlin',              author:'Dewi Puspita',  cat:'Hiburan',       date:'12 Mar 2026', status:'approved', content:'<p>Berlin, FNM — Film panjang karya sutradara Indonesia meraih Silver Bear kategori Best Director di Berlinale 2026, menjadi pencapaian bersejarah sinema Tanah Air.</p>'},
  rupiah:   { emoji:'📉', title:'Rupiah Melemah ke Level Rp 16.800 Per Dolar AS',                 author:'Budi Santoso',  cat:'Ekonomi',       date:'10 Mar 2026', status:'rejected', content:'<p>Jakarta, FNM — Nilai tukar rupiah melemah ke Rp 16.800 per dolar AS dipicu sentimen negatif dari laporan inflasi Amerika Serikat yang lebih tinggi dari perkiraan.</p>'},
};

/* ─── STATUS LABEL ─── */
const LABEL = { pending:'◐ Pending', approved:'● Disetujui', rejected:'✕ Ditolak' };
const BADGE_CLASS = { pending:'b-pending', approved:'b-approved', rejected:'b-rejected' };

/* ─── STATE UNTUK KONFIRMASI ─── */
let pendingRow = null, pendingKey = null, pendingAction = null;

/* ─── HANDLE DROPDOWN CHANGE ─── */
function handleChange(sel) {
  const val = sel.value;
  if (val === 'pending') return; // tidak ada aksi jika tetap pending
  const row = sel.closest('tr');
  const key = row.dataset.key;

  pendingRow    = row;
  pendingKey    = key;
  pendingAction = val;

  // Reset dropdown ke pending dulu (konfirmasi belum selesai)
  sel.value = 'pending';

  // Tampilkan modal konfirmasi
  const article = DB[key];
  document.getElementById('mcTitle').textContent = val === 'approved' ? 'Setujui Artikel' : 'Tolak Artikel';
  document.getElementById('mcSub').textContent   = article.title;
  document.getElementById('mcApproveSection').style.display = val === 'approved' ? 'block' : 'none';
  document.getElementById('mcRejectSection').style.display  = val === 'rejected'  ? 'block' : 'none';
  document.getElementById('rejectNoteText').value = '';
  document.getElementById('modalConfirm').classList.add('open');
}

function cancelConfirm() {
  document.getElementById('modalConfirm').classList.remove('open');
  pendingRow = pendingKey = pendingAction = null;
}

function finalizeApprove() {
  applyStatus(pendingRow, pendingKey, 'approved');
  cancelConfirm();
  showToast('✅', 'Artikel berhasil disetujui!');
}

function finalizeReject() {
  const note = document.getElementById('rejectNoteText').value.trim();
  if (!note) { alert('Harap isi alasan penolakan untuk Editor.'); return; }
  applyStatus(pendingRow, pendingKey, 'rejected');
  cancelConfirm();
  showToast('↩️', 'Artikel ditolak & dikembalikan ke Editor.');
}

/* ─── TERAPKAN STATUS KE BARIS ─── */
function applyStatus(row, key, status) {
  DB[key].status = status;
  row.dataset.status = status;
  // Ganti kolom status (td ke-6, index 5)
  const statusTd = row.cells[5];
  statusTd.innerHTML = `<span class="badge ${BADGE_CLASS[status]}">${LABEL[status]}</span>`;
  updateCounts();
}

/* ─── UPDATE COUNTER BADGE DAN TAB ─── */
function updateCounts() {
  const rows = document.querySelectorAll('#newsBody tr');
  let cnt = { pending:0, approved:0, rejected:0, all:0 };
  rows.forEach(r => { cnt[r.dataset.status]++; cnt.all++; });
  document.getElementById('cnt-all').textContent     = cnt.all;
  document.getElementById('cnt-pending').textContent  = cnt.pending;
  document.getElementById('cnt-approved').textContent = cnt.approved;
  document.getElementById('cnt-rejected').textContent = cnt.rejected;
  const pendingCountEl = document.getElementById('pendingCount');
  if (pendingCountEl) pendingCountEl.textContent = cnt.pending;
}

/* ─── FILTER TAB ─── */
function filterTab(el, status) {
  document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  let visible = 0;
  document.querySelectorAll('#newsBody tr').forEach(r => {
    const show = status === 'all' || r.dataset.status === status;
    r.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('tableCount').textContent = `Menampilkan ${visible} artikel`;
  document.getElementById('pagerInfo').textContent  = `Menampilkan ${visible} dari 9 artikel`;
}

/* ─── MODAL DETAIL ─── */
function openModal(key) {
  const a = DB[key];
  document.getElementById('mdTitle').textContent    = a.title;
  document.getElementById('mdSub').textContent      = `${a.author} · ${a.cat} · ${a.date}`;
  document.getElementById('mdEmoji').textContent    = a.emoji;
  document.getElementById('md-author').textContent  = a.author;
  document.getElementById('md-cat').textContent     = a.cat;
  document.getElementById('md-date').textContent    = a.date;
  document.getElementById('md-status').textContent  = LABEL[a.status] || a.status;
  document.getElementById('mdContent').innerHTML    = a.content;

  // Kotak keputusan hanya tampil bila masih pending
  const vw = document.getElementById('mdVerdictWrap');
  vw.style.display = a.status === 'pending' ? 'block' : 'none';
  document.getElementById('mdRejectNote').classList.remove('show');
  document.getElementById('mdRejectText').value = '';

  // simpan key untuk verdictApprove / verdictReject
  document.getElementById('modalDetail').dataset.currentKey = key;
  document.getElementById('modalDetail').classList.add('open');
}
function closeDetail() {
  document.getElementById('modalDetail').classList.remove('open');
}
function verdictApprove() {
  const key = document.getElementById('modalDetail').dataset.currentKey;
  const row = document.querySelector(`tr[data-key="${key}"]`);
  applyStatus(row, key, 'approved');
  closeDetail();
  showToast('✅', 'Artikel berhasil disetujui!');
}
function verdictReject() {
  document.getElementById('mdRejectNote').classList.add('show');
}
function closeRejectNote() {
  document.getElementById('mdRejectNote').classList.remove('show');
  document.getElementById('mdRejectText').value = '';
}
function submitRejectFromDetail() {
  const note = document.getElementById('mdRejectText').value.trim();
  if (!note) { alert('Harap isi alasan penolakan untuk Editor.'); return; }
  const key = document.getElementById('modalDetail').dataset.currentKey;
  const row = document.querySelector(`tr[data-key="${key}"]`);
  applyStatus(row, key, 'rejected');
  closeDetail();
  showToast('↩️', 'Artikel ditolak & dikembalikan ke Editor.');
}

/* ─── NOTIF ─── */
function toggleNotif() { document.getElementById('notifPanel').classList.toggle('open'); }
document.addEventListener('click', e => {
  if (!e.target.closest('.tb-icon') && !e.target.closest('.notif-panel'))
    document.getElementById('notifPanel').classList.remove('open');
});

/* ─── TOAST ─── */
let toastTimer;
function showToast(ico, msg) {
  clearTimeout(toastTimer);
  const t = document.getElementById('toast');
  document.getElementById('toastIco').textContent = ico;
  document.getElementById('toastMsg').textContent = msg;
  t.style.display = 'flex'; t.style.opacity = '1';
  toastTimer = setTimeout(() => {
    t.style.opacity = '0';
    setTimeout(() => { t.style.display = 'none'; }, 300);
  }, 3000);
}

/* ─── LOGIN / LOGOUT ─── */
function doLogin() {
  const e = document.getElementById('loginEmail').value;
  const p = document.getElementById('loginPass').value;
  if (!e || !p) { alert('Masukkan email dan password!'); return; }
  const lv = document.getElementById('loginView');
  lv.style.transition = 'opacity .4s'; lv.style.opacity = '0';
  setTimeout(() => { lv.style.display = 'none'; }, 400);
}
function doLogout() {
  if (!confirm('Yakin ingin keluar?')) return;
  const lv = document.getElementById('loginView');
  lv.style.display = 'flex'; lv.style.opacity = '0';
  setTimeout(() => { lv.style.transition = 'opacity .4s'; lv.style.opacity = '1'; }, 10);
}

/* ─── CLOSE MODAL ON BACKDROP ─── */
document.getElementById('modalConfirm').addEventListener('click', function(e){ if(e.target===this) cancelConfirm(); });
document.getElementById('modalDetail').addEventListener('click', function(e){ if(e.target===this) closeDetail(); });
</script>
@endsection