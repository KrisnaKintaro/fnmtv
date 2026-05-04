@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
<!-- ══ PAGE: COMMENTS (UC-06) ══ -->
<di id="page-comments" class="page active">
    <div class="section-title">Moderasi Komentar</div>
    <div class="warn-box" id="warnBox" style="display:none;">⚠️ Terdapat <b id="pendingCount">0</b> komentar yang perlu ditinjau.</div>
    <div class="filter-bar">
        <div class="tab-pills">
            <div class="tab-p active" onclick="filterKomentar('all')">Semua (<span id="allCount">0</span>)</div>
            <div class="tab-p" onclick="filterKomentar('pending')">Perlu Review (<span id="pendingCountTab">0</span>)</div>
            <div class="tab-p" onclick="filterKomentar('spam')">Terindikasi Spam (<span id="spamCount">0</span>)</div>
            <div class="tab-p" onclick="filterKomentar('approved')">Disetujui (<span id="approvedCount">0</span>)</div>
        </div>
    </div>
    <div class="card">
        <!-- Wadah List Komentar -->
        <div id="komentarContainer"></div>

        <!-- Wadah Empty State -->
        <div class="empty-state" id="emptyKomentar" style="display:none;">
            <div class="ico">📭</div>
            <p>Tidak ada komentar untuk ditampilkan.</p>
        </div>

        <!-- Wadah Pagination -->
        <div class="pager" style="padding: 16px 22px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
            <div id="komentarPagination" style="display:flex; gap:4px;"></div>
            <div class="pg-info" id="komentarInfo">Menampilkan 0 dari 0 komentar</div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
  let allKomentar = [];
  let currentFilter = 'all';
  let keywordSearch = '';

  // 1. Inisialisasi DataTableEngine
  const komentarTable = new DataTableEngine({
    tableBody: '#komentarContainer',
    paginationWrapper: '#komentarPagination',
    infoWrapper: '#komentarInfo',
    emptyState: '#emptyKomentar',
    perPage: 10, // Dibatasi 10 komentar per halaman
    renderRowHTML: function(komentar) {
        const rawNama = komentar.user ? komentar.user.username : (komentar.nama || 'Anonim');
        const amanNama = $('<div>').text(rawNama).html();
        const amanKomentar = $('<div>').text(komentar.isi_komentar).html();

        const inicial = amanNama[0].toUpperCase();
        const bgColor = ['#cc0000', '#1a3a7a', '#1a7a3c', '#b86200'][komentar.id % 4];

        const statusColor = komentar.status_moderasi === 'Approved' ? 'b-ok' :
                           (komentar.status_moderasi === 'Spam' ? 'b-spam' : 'b-review');
        const statusIcon = komentar.status_moderasi === 'Approved' ? '✅ OK' :
                          (komentar.status_moderasi === 'Spam' ? '🚨 Spam' : '⏳ Pending');

        const tanggal = new Date(komentar.created_at).toLocaleDateString('id-ID', {
          day: 'numeric', month: 'short', year: 'numeric'
        });
        const waktu = new Date(komentar.created_at).toLocaleTimeString('id-ID', {
          hour: '2-digit', minute: '2-digit'
        });

        return `
          <div class="cmt-item" ${komentar.status_moderasi === 'Spam' ? 'style="background:#fef9f9;"' : ''}>
            <div class="cmt-avatar" style="background:${bgColor};">${inicial}</div>
            <div class="cmt-body">
              <div class="cmt-user">${amanNama}
                <span class="badge ${statusColor}" style="margin-left:6px;">${statusIcon}</span>
              </div>
              <div class="cmt-article">Pada: "${komentar.berita?.judul_berita || 'Berita tidak ditemukan'}"</div>
              <div class="cmt-text">${amanKomentar}</div>
              <div class="cmt-time">${tanggal}, ${waktu}</div>
              <div class="cmt-acts">
                ${komentar.status_moderasi !== 'Approved' ? `
                  <button class="btn btn-ghost btn-sm" onclick="ubahStatusKomentar(${komentar.id}, 'Approved')">✅ Setujui</button>
                ` : ''}
                ${komentar.status_moderasi !== 'Spam' ? `
                  <button class="btn btn-sm" style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;" onclick="ubahStatusKomentar(${komentar.id}, 'Spam')">🚨 Tandai Spam</button>
                ` : ''}
                <button class="btn btn-sm" style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;" onclick="hapusKomentar(${komentar.id})">🗑️ Hapus</button>
              </div>
            </div>
          </div>
        `;
    }
  });

 $(document).ready(function() {
    $('#tbTitle').text('Moderasi Komentar');
    $('#tbCrumb').text('Admin / Moderasi Komentar');

    // --- 1. FITUR PENCARIAN NAVBAR ---
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.placeholder = 'Cari nama atau isi komentar...';
        searchInput.value = '';
        searchInput.onkeyup = function() {
            keywordSearch = this.value.toLowerCase();
            applyKomentarFilters(); // Gabungin search sama filter tab
        };
    }

    loadKomentarFromAPI();

    // --- 2. FITUR NOTIFIKASI LONCENG ---
    SmartNotif.init({
        apiUrl: '/api/admin/manajemen_komentar/ambilData?status=Pending',
        renderItemHTML: function(item) {
            const rawNama = item.user ? item.user.username : (item.nama || 'Anonim');
            const amanNama = $('<div>').text(rawNama).html();
            // Potong isi komentar biar ga kepanjangan di notif
            const cuplikan = $('<div>').text(item.isi_komentar).html().substring(0, 40) + '...';

            return `
                <div class="notif-item" onclick="sorotKomentar(${item.id})" style="cursor:pointer; padding:12px; border-bottom:1px solid #eee; display:flex; gap:12px; background: #fffaf0; transition: background 0.2s;">
                    <div style="font-size:20px;">💬</div>
                    <div class="notif-txt">
                        <div style="font-weight:700; font-size:13px; color:var(--text);">Review: ${amanNama}</div>
                        <div style="font-size:12px; color:#555; line-height:1.4;">"${cuplikan}"</div>
                        <div style="font-size:10px; color:var(--red); margin-top:4px; font-weight:600;">Klik untuk moderasi</div>
                    </div>
                </div>
            `;
        }
    });
  });

  async function loadKomentarFromAPI() {
    try {
      const response = await fetch('/api/admin/manajemen_komentar/ambilData');
      const result = await response.json();

      if (result.status === 'success') {
        allKomentar = result.data;
        updateCounts();

        komentarTable.loadData(allKomentar);

        // JANGAN PANGGIL filterKomentar('all') LAGI DI SINI!
        // Karena applyKomentarFilters udah otomatis dipanggil sama komentarTable pas diload
        applyKomentarFilters();
      } else {
        Toast.show('error', 'Gagal memuat data komentar');
      }
    } catch (error) {
      console.error('Error:', error);
      Toast.show('error', 'Terjadi kesalahan saat memuat data');
      document.getElementById('komentarContainer').innerHTML = `
        <div style="padding: 40px; text-align: center; color: var(--red);">
            <div style="font-size: 40px; margin-bottom: 10px;">🔌</div>
            <div style="font-weight: 600;">Koneksi Terputus</div>
            <div style="font-size: 13px;">Gagal terhubung ke API. Silakan refresh halaman.</div>
        </div>
      `;
    }
  }

  function updateCounts() {
    const pending = allKomentar.filter(k => k.status_moderasi === 'Pending').length;
    const spam = allKomentar.filter(k => k.status_moderasi === 'Spam').length;
    const approved = allKomentar.filter(k => k.status_moderasi === 'Approved').length;

    $('#allCount').text(allKomentar.length);
    $('#pendingCount').text(pending);
    $('#pendingCountTab').text(pending);
    $('#spamCount').text(spam);
    $('#approvedCount').text(approved);

    document.getElementById('warnBox').style.display = pending > 0 ? 'block' : 'none';
  }

  function filterKomentar(filterStatus) {
    currentFilter = filterStatus;

    // Update style tombol tab pills
    document.querySelectorAll('.tab-p').forEach(el => el.classList.remove('active'));
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    } else {
        // Fallback misal dipanggil lewat fungsi JS (bukan diklik manual)
        const tabList = document.querySelectorAll('.tab-p');
        if (filterStatus === 'all') tabList[0].classList.add('active');
        if (filterStatus === 'pending') tabList[1].classList.add('active');
    }

    applyKomentarFilters(); // Panggil fungsi filter gabungan
  }

  // --- FUNGSI GABUNGAN (SEARCH + TAB FILTER) ---
  function applyKomentarFilters() {
      komentarTable.setFilterAndSearch((komentar) => {
          // 1. Cek Status (Tab)
          let matchStatus = true;
          if (currentFilter !== 'all') {
              const targetStatus = currentFilter.charAt(0).toUpperCase() + currentFilter.slice(1);
              matchStatus = komentar.status_moderasi === targetStatus;
          }

          // 2. Cek Pencarian (Search Input)
          let matchSearch = true;
          if (keywordSearch !== '') {
              const rawNama = komentar.user ? komentar.user.username : (komentar.nama || 'Anonim');
              const stringTeks = (rawNama + " " + komentar.isi_komentar).toLowerCase();
              matchSearch = stringTeks.includes(keywordSearch);
          }

          return matchStatus && matchSearch;
      });
  }

  // --- 3. FUNGSI KLIK DARI NOTIFIKASI ---
  function sorotKomentar(idKomentar) {
      // Buka tab "Perlu Review" biar nyambung
      currentFilter = 'pending';
      document.querySelectorAll('.tab-p').forEach(el => el.classList.remove('active'));
      document.querySelectorAll('.tab-p')[1].classList.add('active');

      // Kosongin kotak pencarian biar ga ganggu
      const searchInput = document.getElementById('searchInput');
      if(searchInput) searchInput.value = '';
      keywordSearch = '';

      // Trik Jitu: Paksa filter tabel cuma nampilin komentar dengan ID ini aja
      komentarTable.setFilterAndSearch((k) => k.id === idKomentar);

      // Tutup panel notif kalau masih kebuka
      const panel = document.getElementById('notifPanel');
      if (panel) panel.classList.remove('open');

      Toast.show('success', 'Menyorot komentar dari notifikasi.');
  }

  // --- Sisa fungsi API lu tetep sama persis (ubahStatusKomentar & hapusKomentar) ---
  async function ubahStatusKomentar(id, status) {
    try {
      const response = await fetch(`/api/admin/manajemen_komentar/ubahStatus/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ status_moderasi: status })
      });
      const result = await response.json();
      if (result.status === 'success') {
        Toast.show('success', result.message);
        loadKomentarFromAPI();
        // Update badge global juga!
        if (typeof updateGlobalKomentarBadge === "function") updateGlobalKomentarBadge();
      } else {
        Toast.show('error', result.message || 'Gagal mengubah status');
      }
    } catch (error) {
      console.error('Error:', error);
      Toast.show('error', 'Terjadi kesalahan');
    }
  }

  async function hapusKomentar(id) {
    if (confirm('Yakin ingin menghapus komentar ini?')) {
      try {
        const response = await fetch(`/api/admin/manajemen_komentar/hapusKomentar/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          }
        });
        const result = await response.json();
        if (result.status === 'success') {
          Toast.show('success', result.message);
          loadKomentarFromAPI();
          if (typeof updateGlobalKomentarBadge === "function") updateGlobalKomentarBadge();
        } else {
          Toast.show('error', result.message || 'Gagal menghapus komentar');
        }
      } catch (error) {
        console.error('Error:', error);
        Toast.show('error', 'Terjadi kesalahan');
      }
    }
  }
</script>
@endsection
