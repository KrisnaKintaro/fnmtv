@extends('Admin.master_admin')

@section('css')
<style>
    /* ── FIX RESPONSIVE: Scroll Tab Filter & Wrapper ── */
    .filter-bar {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px; /* Space biar scrollbar gak nabrak box shadow */
    }

    .tab-pills {
        display: inline-flex;
        flex-wrap: nowrap;
        min-width: max-content; /* Paksa tab berjajar ke samping */
    }

    /* ── FIX RESPONSIVE: Layout Komentar HP ── */
    @media screen and (max-width: 768px) {
        .cmt-item {
            padding: 16px 14px;
        }
        .cmt-avatar {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }
        .cmt-acts {
            width: 100%;
            justify-content: flex-end; /* Tombol aksi geser ke kanan kalau di HP */
            margin-top: 10px;
        }
    }
</style>
@endsection

@section('konten')
<div id="page-comments" class="page active">
    <div class="section-title">Moderasi Komentar</div>

    <div class="warn-box" id="warnBox" style="display:none; line-height: 1.5;">
        ⚠️ Terdapat <b id="pendingCount">0</b> komentar yang perlu ditinjau.
    </div>

    <div class="filter-bar">
        <div class="tab-pills">
            <div class="tab-p active" onclick="filterKomentar('all')">Semua (<span id="allCount">0</span>)</div>
            <div class="tab-p" onclick="filterKomentar('pending')">Perlu Review (<span id="pendingCountTab">0</span>)</div>
            <div class="tab-p" onclick="filterKomentar('spam')">Terindikasi Spam (<span id="spamCount">0</span>)</div>
            <div class="tab-p" onclick="filterKomentar('approved')">Disetujui (<span id="approvedCount">0</span>)</div>
        </div>
    </div>

    <div class="card">
        <div id="komentarContainer"></div>

        <div class="empty-state" id="emptyKomentar" style="display:none; padding: 60px 20px;">
            <div class="ico" style="font-size:48px; margin-bottom:12px;">📭</div>
            <p style="font-size:14px; font-weight:600; color:var(--text);">Tidak ada komentar untuk ditampilkan.</p>
            <p style="font-size:12px; color:var(--muted); margin-top:4px;">Coba ganti filter atau kata kunci pencarian.</p>
        </div>

        <div class="pager" style="flex-wrap:wrap;">
            <div id="komentarPagination" style="display:flex; gap:4px; flex-wrap:wrap;"></div>
            <div class="pg-info" id="komentarInfo">Menampilkan 0 dari 0 komentar</div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="modalRemoveConfirm" style="display:none;">
    <div class="modal" style="max-width:380px; text-align:center; padding:30px;">
        <div style="font-size:40px; margin-bottom:10px;">🗑️</div>
        <h3 style="font-family: 'Merriweather', serif; margin-bottom:10px;">Hapus Komentar?</h3>
        <p style="font-size:13px; color:var(--muted); margin-bottom:24px;">Komentar yang dihapus tidak bisa dikembalikan.</p>
        <div style="display:flex; gap:10px;">
            <button class="btn btn-outline" style="flex:1; justify-content:center;" onclick="ModalManager.close('modalRemoveConfirm')">Batal</button>
            <button class="btn btn-red" style="flex:1; justify-content:center;" onclick="executeHapusKomentar()">Ya, Hapus</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
  let allKomentarDB = [];
  let currentFilter = 'all';
  let pendingDeleteKomentarId = null; // Variabel penyimpan ID untuk dihapus

  $(document).ready(function() {
    $('#tbTitle').text('Moderasi Komentar');
    $('#tbCrumb').text('Admin / Moderasi Komentar');

    // SINKRONISASI SEARCH BAR PC & HP
    const searchInputs = document.querySelectorAll('#searchInput, .mobile-search-input');
    searchInputs.forEach(input => {
        if(input) {
            input.placeholder = 'Cari komentar atau nama user...';
            input.value = '';
            input.addEventListener('keyup', function() {
                filterKomentar();
            });
        }
    });

    loadKomentarFromAPI();
  });

  async function loadKomentarFromAPI() {
    Toast.show('info', 'Memuat data komentar...');
    try {
      const response = await fetch('/api/admin/manajemen_komentar/ambilData', {
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
      });
      const result = await response.json();

      if (result.status === 'success') {
        allKomentarDB = result.data;
        updateBadgeCounts();
        filterKomentar();
        Toast.show('success', 'Data komentar berhasil dimuat.');
      } else {
        Toast.show('error', result.message || 'Gagal memuat data');
      }
    } catch (error) {
      console.error('Error fetching komentar:', error);
      Toast.show('error', 'Terjadi kesalahan sistem');
    }
  }

  function updateBadgeCounts() {
    const all = allKomentarDB.length;
    const pending = allKomentarDB.filter(k => k.status_moderasi === 'Pending').length;
    const spam = allKomentarDB.filter(k => k.status_moderasi === 'Spam').length;
    const approved = allKomentarDB.filter(k => k.status_moderasi === 'Approved').length;

    $('#allCount').text(all);
    $('#pendingCountTab').text(pending);
    $('#spamCount').text(spam);
    $('#approvedCount').text(approved);

    if (pending > 0) {
      $('#pendingCount').text(pending);
      $('#warnBox').show();
      $('#badgePendingKomentar').text(pending).show();
    } else {
      $('#warnBox').hide();
      $('#badgePendingKomentar').hide();
    }
  }

  // --- INISIALISASI DATATABLE ENGINE ---
  const komentarEngine = new DataTableEngine({
    tableBody: '#komentarContainer',
    paginationWrapper: '#komentarPagination',
    infoWrapper: '#komentarInfo',
    emptyState: '#emptyKomentar',
    perPage: 5,
    renderRowHTML: function(k) {
      const nama = k.user ? k.user.username : 'Unknown';
      const initial = nama.charAt(0).toUpperCase();
      const judulBerita = k.berita ? k.berita.judul_berita : 'Berita Dihapus';

      const tglStr = k.created_at ? new Date(k.created_at).toLocaleString('id-ID', {
        day:'numeric', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit'
      }) : '-';

      let badgeHtml = '';
      let aksiHtml = '';

      if (k.status_moderasi === 'Pending') {
        badgeHtml = `<span class="badge b-review">Perlu Review</span>`;
        aksiHtml = `
          <button class="btn btn-sm btn-outline" style="color:var(--success);border-color:var(--success);" onclick="ubahStatusKomentar(${k.id}, 'Approved')">✓ Setujui</button>
          <button class="btn btn-sm btn-outline" style="color:var(--warning);border-color:var(--warning);" onclick="ubahStatusKomentar(${k.id}, 'Spam')">⚠️ Tandai Spam</button>
          <button class="btn btn-sm btn-red" onclick="hapusKomentar(${k.id})">🗑️ Hapus</button>
        `;
      } else if (k.status_moderasi === 'Spam') {
        badgeHtml = `<span class="badge b-spam">Terindikasi Spam</span>`;
        aksiHtml = `
          <button class="btn btn-sm btn-outline" onclick="ubahStatusKomentar(${k.id}, 'Approved')">Pulihkan (Setujui)</button>
          <button class="btn btn-sm btn-red" onclick="hapusKomentar(${k.id})">🗑️ Hapus Permanen</button>
        `;
      } else {
        badgeHtml = `<span class="badge b-pub">Disetujui</span>`;
        aksiHtml = `
          <button class="btn btn-sm btn-outline" style="color:var(--warning);border-color:var(--warning);" onclick="ubahStatusKomentar(${k.id}, 'Spam')">⚠️ Tandai Spam</button>
          <button class="btn btn-sm btn-red" onclick="hapusKomentar(${k.id})">🗑️ Hapus</button>
        `;
      }

      // XSS Protection
      const amanNama = $('<div>').text(nama).html();
      const amanIsi = $('<div>').text(k.isi_komentar).html();
      const amanJudulBerita = $('<div>').text(judulBerita).html();

      return `
        <div class="cmt-item">
            <div class="cmt-avatar">${initial}</div>
            <div class="cmt-body">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px;">
                    <div style="min-width:0; flex:1;">
                        <div class="cmt-user">${amanNama}</div>
                        <div class="cmt-article" title="${amanJudulBerita}">Pada: <b>${amanJudulBerita}</b></div>
                    </div>
                    <div>${badgeHtml}</div>
                </div>
                <div class="cmt-text" style="word-break: break-word;">${amanIsi}</div>
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-top:8px;">
                    <div class="cmt-time">${tglStr}</div>
                    <div class="cmt-acts">${aksiHtml}</div>
                </div>
            </div>
        </div>
      `;
    },
    insertMethod: 'html' // karena container nya <div> bukan <tbody>
  });

  function filterKomentar(status) {
    if (status) {
      currentFilter = status;
      $('.tab-p').removeClass('active');
      $(`.tab-p[onclick="filterKomentar('${status}')"]`).addClass('active');
    }

    const desktopSearch = document.getElementById('searchInput');
    const mobileSearch = document.querySelector('.mobile-search-input');
    let keyword = '';
    if (desktopSearch && desktopSearch.value) keyword = desktopSearch.value.toLowerCase();
    else if (mobileSearch && mobileSearch.value) keyword = mobileSearch.value.toLowerCase();

    let filtered = allKomentarDB;

    // 1. Filter Status
    if (currentFilter === 'pending') {
      filtered = filtered.filter(k => k.status_moderasi === 'Pending');
    } else if (currentFilter === 'spam') {
      filtered = filtered.filter(k => k.status_moderasi === 'Spam');
    } else if (currentFilter === 'approved') {
      filtered = filtered.filter(k => k.status_moderasi === 'Approved');
    }

    // 2. Filter Keyword
    if (keyword) {
      filtered = filtered.filter(k => {
        const u = k.user ? k.user.username.toLowerCase() : '';
        const i = k.isi_komentar ? k.isi_komentar.toLowerCase() : '';
        const b = k.berita ? k.berita.judul_berita.toLowerCase() : '';
        return u.includes(keyword) || i.includes(keyword) || b.includes(keyword);
      });
    }

    komentarEngine.loadData(filtered);
  }

  async function ubahStatusKomentar(id, status) {
    try {
      const response = await fetch(`/api/admin/manajemen_komentar/ubahStatus/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ status_moderasi: status })
      });
      const result = await response.json();
      if (result.status === 'success') {
        Toast.show('success', result.message);
        loadKomentarFromAPI();
        if (typeof updateGlobalKomentarBadge === "function") updateGlobalKomentarBadge();
      } else {
        Toast.show('error', result.message || 'Gagal mengubah status');
      }
    } catch (error) {
      console.error('Error:', error);
      Toast.show('error', 'Terjadi kesalahan');
    }
  }

  // Buka Modal Hapus
  function hapusKomentar(id) {
    pendingDeleteKomentarId = id;
    ModalManager.open('modalRemoveConfirm');
  }

  // Eksekusi Hapus dari Modal
  async function executeHapusKomentar() {
    if (!pendingDeleteKomentarId) return;

    try {
      const response = await fetch(`/api/admin/manajemen_komentar/hapusKomentar/${pendingDeleteKomentarId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
      });
      const result = await response.json();

      if (result.status === 'success') {
        ModalManager.close('modalRemoveConfirm');
        Toast.show('success', '🗑️ ' + result.message);
        loadKomentarFromAPI();
        if (typeof updateGlobalKomentarBadge === "function") updateGlobalKomentarBadge();
        pendingDeleteKomentarId = null;
      } else {
        ModalManager.close('modalRemoveConfirm');
        Toast.show('error', result.message || 'Gagal menghapus komentar');
      }
    } catch (error) {
      console.error('Error:', error);
      ModalManager.close('modalRemoveConfirm');
      Toast.show('error', 'Terjadi kesalahan sistem');
    }
  }
</script>
@endsection
