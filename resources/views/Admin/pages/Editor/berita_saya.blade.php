@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
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
                <div class="ico-btn" title="Edit" onclick="showPage('write-news',null)">✏️</div>
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
                <div class="ico-btn" title="Edit" onclick="showPage('write-news',null)">✏️</div>
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
                <div class="ico-btn" title="Edit" onclick="showPage('write-news',null)">✏️</div>
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
                <div class="ico-btn" title="Edit" onclick="showPage('write-news',null)">✏️</div>
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
                <div class="ico-btn" title="Revisi &amp; Edit" onclick="showPage('write-news',null)">✏️</div>
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
                <div class="ico-btn" title="Revisi &amp; Edit" onclick="showPage('write-news',null)">✏️</div>
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
@endsection
@section('js')
<script>
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
  const [title, crumb] = pageTitles[id] || ['—','—'];
  document.getElementById('tbTitle').textContent = title;
  document.getElementById('tbCrumb').textContent = crumb;
}

/* ── STATUS TOGGLE (Write page) ── */
function setStatus(v) {
  const d = document.getElementById('tglDraft');
  const p = document.getElementById('tglPending');
  const h = document.getElementById('statusHint');
  if (v === 'draft') {
    d.className = 'tgl-opt sel-draft';
    p.className = 'tgl-opt';
    h.textContent = 'Draft: hanya terlihat oleh Anda';
  } else {
    d.className = 'tgl-opt';
    p.className = 'tgl-opt sel-pending';
    h.textContent = 'Pending: artikel akan dikirim ke Redaksi untuk diverifikasi';
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
  if (rowToDelete) {
    rowToDelete.style.transition = 'opacity .3s';
    rowToDelete.style.opacity = '0';
    setTimeout(() => { rowToDelete.remove(); }, 300);
  }
  closeDelete();
}
</script>
@endsection