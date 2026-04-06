@extends('editor.editor_master')
@section('css')
@endsection
@section('konten')
  <!-- ══ PAGE: TULIS BERITA BARU ══ -->
  <div id="page-write-news" class="page">
    <div class="page-header">
      <div id="backButtonContainer" class="back-button" style="display:none;">
        <button class="btn btn-ghost btn-sm btn-pill" onclick="showPage('my-news', document.querySelectorAll('.s-item')[1])" style="gap:6px;">
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          Kembali
        </button>
      </div>
      <div class="section-title" id="sectionTitle">Tulis Berita Baru</div>
    </div>
    <div class="form-grid">

      <!-- LEFT: Main Form -->
      <div>
        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Informasi Artikel</div>
          <div class="field">
            <label>Judul Berita *</label>
            <input type="text" placeholder="Masukkan judul berita yang menarik...">
          </div>
          <div class="field">
            <label>Slug URL</label>
            <input type="text" placeholder="judul-berita-menarik" style="font-family:'JetBrains Mono',monospace;font-size:13px;">
          </div>
          <div class="field">
            <label>Konten Berita *</label>
            <div class="rte-mock">
              <div class="rte-toolbar">
                <button class="rte-btn"><b>B</b></button>
                <button class="rte-btn"><i>I</i></button>
                <button class="rte-btn"><u>U</u></button>
                <div class="rte-sep"></div>
                <button class="rte-btn">H1</button>
                <button class="rte-btn">H2</button>
                <button class="rte-btn">H3</button>
                <div class="rte-sep"></div>
                <button class="rte-btn">≡</button>
                <button class="rte-btn">≣</button>
                <button class="rte-btn">⊶</button>
                <div class="rte-sep"></div>
                <button class="rte-btn">🔗</button>
                <button class="rte-btn">🖼</button>
                <button class="rte-btn">❝</button>
              </div>
              <div class="rte-body" contenteditable="true"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Sidebar Controls -->
      <div>
        <!-- Publish Box -->
        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Status Pengiriman</div>
          <div class="field" style="margin-bottom:0;">
            <label>Kirim sebagai</label>
            <div class="toggle-group">
              <div class="tgl-opt sel-draft" id="tglDraft" onclick="confirmStatus('draft')">Draft</div>
              <div class="tgl-opt" id="tglPending" onclick="confirmStatus('pending')">Kirim ke Redaksi</div>
            </div>
          </div>
        </div>

        <!-- Thumbnail -->
        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Thumbnail Berita</div>
          <div class="thumb-upload">
            <div class="ico">🖼</div>
            <p><span>Pilih file</span> atau seret ke sini</p>
            <p style="font-size:11px;margin-top:4px;">JPG, PNG, JPEG · Maks. 2 MB</p>
          </div>
        </div>

        <!-- Category -->
        <div class="form-card">
          <div class="form-title">Kategori</div>
          <div class="field" style="margin-bottom:0;">
            <label>Pilih Kategori *</label>
            <select>
              <option value="">-- Pilih Kategori --</option>
              <option>Politik</option>
              <option>Ekonomi</option>
              <option>Teknologi</option>
              <option>Olahraga</option>
              <option>Kesehatan</option>
              <option>Budaya</option>
              <option>Internasional</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ══ PAGE: BERITA SAYA ══ -->
  <div id="page-my-news" class="page active">
    <div class="section-title">Berita Saya</div>

    <!-- Filter Bar -->
    <div class="filter-bar">
      <div class="tab-pills" id="tabPills">
        <div class="tab-p active" onclick="filterTab(this,'all')">Semua <span style="margin-left:4px;background:#ddd;color:#555;font-size:10px;padding:1px 6px;border-radius:8px;">9</span></div>
        <div class="tab-p" onclick="filterTab(this,'draft')">Draft <span style="margin-left:4px;background:#ddd;color:#555;font-size:10px;padding:1px 6px;border-radius:8px;">4</span></div>
        <div class="tab-p" onclick="filterTab(this,'pending')">Pending <span style="margin-left:4px;background:#e6ecf4;color:var(--blue);font-size:10px;padding:1px 6px;border-radius:8px;">3</span></div>
        <div class="tab-p" onclick="filterTab(this,'rejected')">Ditolak <span style="margin-left:4px;background:#fde8e8;color:var(--red);font-size:10px;padding:1px 6px;border-radius:8px;">2</span></div>
      </div>
      <div style="margin-left:auto;display:flex;gap:8px;">
        <select class="filter-select" style="font-size:12px;padding:6px 10px;">
          <option>Semua Kategori</option>
          <option>Politik</option>
          <option>Ekonomi</option>
          <option>Teknologi</option>
          <option>Olahraga</option>
        </select>
        <select class="filter-select" style="font-size:12px;padding:6px 10px;">
          <option>Terbaru</option>
          <option>Terlama</option>
        </select>
      </div>
    </div>

    <!-- Table -->
    <div class="card">
      <div class="card-hd">
        <div class="card-ht">Daftar Berita</div>
        <div class="card-hm" id="tableCount">Menampilkan 9 artikel</div>
      </div>
      <table id="newsTable">
        <thead>
          <tr>
            <th>Thumbnail</th>
            <th>Judul &amp; Informasi</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="newsBody">

          <!-- DRAFT rows -->
          <tr data-status="draft">
            <td><div class="tbl-img">🏛️</div></td>
            <td>
              <div class="tbl-title">Revisi APBN 2026 Diusulkan Naik 12 Persen</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Draft</div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Politik</span></td>
            <td><span class="badge b-draft">Draft</span></td>
            <td style="font-size:12px;color:var(--muted);">30 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" title="Edit" onclick="editFromTable('write-news')">✏️</div>
                <div class="ico-btn" title="Hapus" onclick="confirmDelete(this)">🗑</div>
              </div>
            </td>
          </tr>

          <tr data-status="draft">
            <td><div class="tbl-img">💻</div></td>
            <td>
              <div class="tbl-title">Startup AI Indonesia Raih Pendanaan Seri B $40 Juta</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Draft</div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Teknologi</span></td>
            <td><span class="badge b-draft">Draft</span></td>
            <td style="font-size:12px;color:var(--muted);">29 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" title="Edit" onclick="editFromTable('write-news')">✏️</div>
                <div class="ico-btn" title="Hapus" onclick="confirmDelete(this)">🗑</div>
              </div>
            </td>
          </tr>

          <tr data-status="draft">
            <td><div class="tbl-img">⚽</div></td>
            <td>
              <div class="tbl-title">Timnas U-23 Lolos ke Semifinal SEA Games 2026</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Draft</div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Olahraga</span></td>
            <td><span class="badge b-draft">Draft</span></td>
            <td style="font-size:12px;color:var(--muted);">28 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" title="Edit" onclick="editFromTable('write-news')">✏️</div>
                <div class="ico-btn" title="Hapus" onclick="confirmDelete(this)">🗑</div>
              </div>
            </td>
          </tr>

          <tr data-status="draft">
            <td><div class="tbl-img">🌿</div></td>
            <td>
              <div class="tbl-title">Kebijakan Baru Pengelolaan Sampah Plastik 2026</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Draft</div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Ekonomi</span></td>
            <td><span class="badge b-draft">Draft</span></td>
            <td style="font-size:12px;color:var(--muted);">27 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" title="Edit" onclick="editFromTable('write-news')">✏️</div>
                <div class="ico-btn" title="Hapus" onclick="confirmDelete(this)">🗑</div>
              </div>
            </td>
          </tr>

          <!-- PENDING rows -->
          <tr data-status="pending">
            <td><div class="tbl-img">🌾</div></td>
            <td>
              <div class="tbl-title">Harga Beras Naik Jelang Lebaran, Pemerintah Buka Impor</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Menunggu Verifikasi Redaksi</div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Ekonomi</span></td>
            <td><span class="badge b-review">Pending</span></td>
            <td style="font-size:12px;color:var(--muted);">26 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" style="opacity:.4;cursor:not-allowed;" title="Tidak dapat diedit saat Pending">✏️</div>
              </div>
            </td>
          </tr>

          <tr data-status="pending">
            <td><div class="tbl-img">🏥</div></td>
            <td>
              <div class="tbl-title">BPJS Kesehatan Tanggung Biaya Operasi Jantung Terbaru</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Menunggu Verifikasi Redaksi</div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Kesehatan</span></td>
            <td><span class="badge b-review">Pending</span></td>
            <td style="font-size:12px;color:var(--muted);">25 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" style="opacity:.4;cursor:not-allowed;" title="Tidak dapat diedit saat Pending">✏️</div>
              </div>
            </td>
          </tr>

          <tr data-status="pending">
            <td><div class="tbl-img">🌐</div></td>
            <td>
              <div class="tbl-title">KTT ASEAN 2026 Bahas Krisis Pangan dan Energi</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Menunggu Verifikasi Redaksi</div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Internasional</span></td>
            <td><span class="badge b-review">Pending</span></td>
            <td style="font-size:12px;color:var(--muted);">24 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" style="opacity:.4;cursor:not-allowed;" title="Tidak dapat diedit saat Pending">✏️</div>
              </div>
            </td>
          </tr>

          <!-- REJECTED rows -->
          <tr data-status="rejected">
            <td><div class="tbl-img">📉</div></td>
            <td>
              <div class="tbl-title">Rupiah Melemah ke Level Rp 16.800 Per Dolar AS</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Ditolak Redaksi</div>
              <div class="reject-reason">
                <span>⚠️</span>
                <div><b>Alasan Penolakan:</b>Data kurs belum diverifikasi dari sumber resmi Bank Indonesia. Harap perbarui dengan data terkini.</div>
              </div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Ekonomi</span></td>
            <td><span class="badge b-reject">Ditolak</span></td>
            <td style="font-size:12px;color:var(--muted);">22 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" title="Revisi &amp; Edit" onclick="editFromTable('write-news')">✏️</div>
                <div class="ico-btn" title="Hapus" onclick="confirmDelete(this)">🗑</div>
              </div>
            </td>
          </tr>

          <tr data-status="rejected">
            <td><div class="tbl-img">🏙️</div></td>
            <td>
              <div class="tbl-title">Proyek MRT Fase 3 Ditargetkan Rampung 2028</div>
              <div class="tbl-meta">Oleh: Budi Santoso · Ditolak Redaksi</div>
              <div class="reject-reason">
                <span>⚠️</span>
                <div><b>Alasan Penolakan:</b>Judul kurang spesifik dan isi artikel perlu diperlengkap dengan kutipan dari pejabat terkait.</div>
              </div>
            </td>
            <td><span class="badge" style="background:#fde8e8;color:var(--red);">Politik</span></td>
            <td><span class="badge b-reject">Ditolak</span></td>
            <td style="font-size:12px;color:var(--muted);">20 Mar 2026</td>
            <td>
              <div class="act-btns">
                <div class="ico-btn" title="Revisi &amp; Edit" onclick="editFromTable('write-news')">✏️</div>
                <div class="ico-btn" title="Hapus" onclick="confirmDelete(this)">🗑</div>
              </div>
            </td>
          </tr>

        </tbody>
      </table>

      <!-- Pagination -->
      <div class="pager">
        <div class="pg-btn active">1</div>
        <div class="pg-info">Menampilkan 9 dari 9 artikel</div>
      </div>
    </div>
  </div>

</main>

<!-- ══ MODAL: Konfirmasi Status Draft ══ -->
<div id="modalDraft" style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
  <div style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
    <div style="font-size:32px;text-align:center;margin-bottom:12px;">📝</div>
    <div style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">Simpan sebagai Draft?</div>
    <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan disimpan sebagai draft dan hanya terlihat oleh Anda. Anda bisa mengedit dan mengirimnya kapan saja.</div>
    <div style="display:flex;gap:10px;">
      <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('draft')">Batal</button>
      <button class="btn btn-ghost" style="flex:1;" onclick="applyStatus('draft')">Ya, Simpan Draft</button>
    </div>
  </div>
</div>

<!-- ══ MODAL: Konfirmasi Kirim ke Redaksi ══ -->
<div id="modalPending" style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
  <div style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
    <div style="font-size:32px;text-align:center;margin-bottom:12px;">📨</div>
    <div style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">Kirim ke Redaksi?</div>
    <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan dikirim ke Redaksi untuk diverifikasi dan diterbitkan. Pastikan artikel sudah siap sebelum melanjutkan.</div>
    <div style="display:flex;gap:10px;">
      <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('pending')">Batal</button>
      <button class="btn btn-ghost" style="flex:1;" onclick="applyStatus('pending')">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        Ya, Kirim
      </button>
    </div>
  </div>
</div>

<!-- ══ MODAL: Konfirmasi Hapus ══ -->
<div id="modalDelete" style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
  <div style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
    <div style="font-size:32px;text-align:center;margin-bottom:12px;">🗑</div>
    <div style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">Hapus Artikel?</div>
    <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel yang dihapus tidak dapat dipulihkan. Pastikan Anda yakin sebelum melanjutkan.</div>
    <div style="display:flex;gap:10px;">
      <button class="btn btn-outline" style="flex:1;" onclick="closeDelete()">Batal</button>
      <button class="btn btn-red" style="flex:1;" onclick="doDelete()">Ya, Hapus</button>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
let isEditingFromTable = false;

function editFromTable(pageId) {
  isEditingFromTable = true;
  document.getElementById('backButtonContainer').style.display = 'block';
  document.getElementById('sectionTitle').textContent = 'Edit Berita';
  showPage(pageId, null);
}

/* ── LOGIN ── */
function doLogin() {
  const email = document.getElementById('loginEmail').value;
  const pass  = document.getElementById('loginPass').value;
  if (email && pass) {
    const lv = document.getElementById('loginView');
    lv.style.transition = 'opacity .4s';
    lv.style.opacity = '0';
    setTimeout(() => { lv.style.display = 'none'; }, 400);
  } else {
    alert('Masukkan email dan password!');
  }
}
function doLogout() {
  if (confirm('Yakin ingin keluar dari panel editor?')) {
    const lv = document.getElementById('loginView');
    lv.style.display = 'flex';
    lv.style.opacity = '0';
    setTimeout(() => { lv.style.opacity = '1'; lv.style.transition = 'opacity .4s'; }, 10);
  }
}

/* ── PAGE NAV ── */
const pageTitles = {
  'write-news': ['Tulis Berita Baru', 'Editor / Berita / Tulis'],
  'my-news':    ['Berita Saya', 'Editor / Berita Saya'],
};
function showPage(id, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + id).classList.add('active');
  if (el) {
    document.querySelectorAll('.s-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');
  }
  // Reset back button when navigating from sidebar
  if (el) {
    isEditingFromTable = false;
    document.getElementById('backButtonContainer').style.display = 'none';
    document.getElementById('sectionTitle').textContent = 'Tulis Berita Baru';
  }
  const [title, crumb] = pageTitles[id] || ['—','—'];
  document.getElementById('tbTitle').textContent = title;
  document.getElementById('tbCrumb').textContent = crumb;
}

/* ── STATUS TOGGLE (Write page) ── */
function confirmStatus(v) {
  const d = document.getElementById('tglDraft');
  const p = document.getElementById('tglPending');
  // Ubah warna tombol langsung dulu
  if (v === 'draft') {
    d.className = 'tgl-opt sel-draft';
    p.className = 'tgl-opt';
    document.getElementById('modalDraft').style.display = 'flex';
  } else {
    d.className = 'tgl-opt';
    p.className = 'tgl-opt sel-pending';
    document.getElementById('modalPending').style.display = 'flex';
  }
}
function closeStatusModal(v) {
  const d = document.getElementById('tglDraft');
  const p = document.getElementById('tglPending');
  // Batal: kembalikan visual ke posisi sebelumnya
  if (v === 'draft') {
    document.getElementById('modalDraft').style.display = 'none';
    d.className = 'tgl-opt';
    p.className = 'tgl-opt sel-pending';
  } else {
    document.getElementById('modalPending').style.display = 'none';
    d.className = 'tgl-opt sel-draft';
    p.className = 'tgl-opt';
  }
}
function applyStatus(v) {
  // Konfirmasi: tinggal tutup modal, warna sudah berubah dari confirmStatus
  if (v === 'draft') {
    document.getElementById('modalDraft').style.display = 'none';
  } else {
    document.getElementById('modalPending').style.display = 'none';
  }
}

/* ── FILTER TABS ── */
function filterTab(el, status) {
  document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  const rows = document.querySelectorAll('#newsBody tr');
  let visible = 0;
  rows.forEach(r => {
    const match = status === 'all' || r.dataset.status === status;
    r.style.display = match ? '' : 'none';
    if (match) visible++;
  });
  document.getElementById('tableCount').textContent = `Menampilkan ${visible} artikel`;
}

/* ── NOTIF ── */
function toggleNotif() {
  document.getElementById('notifPanel').classList.toggle('open');
}
document.addEventListener('click', e => {
  if (!e.target.closest('.tb-icon') && !e.target.closest('.notif-panel'))
    document.getElementById('notifPanel').classList.remove('open');
});

/* ── DELETE MODAL ── */
let rowToDelete = null;
function confirmDelete(btn) {
  rowToDelete = btn.closest('tr');
  document.getElementById('modalDelete').style.display = 'flex';
}
function closeDelete() {
  document.getElementById('modalDelete').style.display = 'none';
  rowToDelete = null;
}
function doDelete() {
  const row = rowToDelete;
  // Tutup modal & reset state dulu
  const modal = document.getElementById('modalDelete');
  modal.style.display = 'none';
  rowToDelete = null;

  if (row) {
    const cells = row.querySelectorAll('td');
    // Fade out
    row.style.transition = 'opacity .2s ease';
    row.style.opacity = '0';
    // Collapse via td
    setTimeout(() => {
      cells.forEach(td => {
        td.style.transition = 'max-height .3s ease, padding .3s ease';
        td.style.overflow = 'hidden';
        td.style.maxHeight = td.scrollHeight + 'px';
        requestAnimationFrame(() => {
          td.style.maxHeight = '0';
          td.style.paddingTop = '0';
          td.style.paddingBottom = '0';
        });
      });
      setTimeout(() => { row.remove(); }, 320);
    }, 200);
  }
}
</script>
@endsection