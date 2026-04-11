@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
<!-- ══ PAGE: COMMENTS (UC-06) ══ -->
<div id="page-comments" class="page active">
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
    <div class="card" id="komentarContainer">
    </div>
</div>
@endsection

@section('js')
<script>
  let allKomentar = [];
  let filteredKomentar = [];
  let currentFilter = 'all';

  $(document).ready(function() {
    $('#tbTitle').text('Moderasi Komentar');
    $('#tbCrumb').text('Admin / Moderasi Komentar');
    loadKomentarFromAPI();
  });

  async function loadKomentarFromAPI() {
    const container = document.getElementById('komentarContainer');

    // TAMPILAN LOADING SEBELUM FETCH API
    container.innerHTML = `
      <div style="padding: 60px 20px; text-align: center; color: var(--muted); font-family: 'Source Sans 3';">
          <div style="font-size: 40px; margin-bottom: 12px; animation: pulse 1.5s infinite;">⏳</div>
          <div style="font-weight: 600; font-size: 16px; color: var(--text);">Mengambil Data...</div>
          <div style="font-size: 13px; margin-top: 6px;">Sedang mengambil data komentar dari API, mohon tunggu sebentar.</div>
      </div>
      <style>
          @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
      </style>
    `;

    try {
      const response = await fetch('/api/admin/manajemen_komentar/ambilData');
      const result = await response.json();

      if (result.status === 'success') {
        allKomentar = result.data;
        updateCounts();
        filterKomentar('all');
      } else {
        Toast.show('error', 'Gagal memuat data komentar');
      }
    } catch (error) {
      console.error('Error:', error);
      Toast.show('error', 'Terjadi kesalahan saat memuat data');
      // Tampilan kalau API error / mati
      container.innerHTML = `
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

    document.getElementById('allCount').textContent = allKomentar.length;
    document.getElementById('pendingCount').textContent = pending;
    document.getElementById('pendingCountTab').textContent = pending;
    document.getElementById('spamCount').textContent = spam;
    document.getElementById('approvedCount').textContent = approved;

    document.getElementById('warnBox').style.display = pending > 0 ? 'block' : 'none';
  }

  function filterKomentar(filter) {
    currentFilter = filter;

    if (filter === 'all') {
      filteredKomentar = allKomentar;
    } else if (filter === 'pending') {
      filteredKomentar = allKomentar.filter(k => k.status_moderasi === 'Pending');
    } else if (filter === 'spam') {
      filteredKomentar = allKomentar.filter(k => k.status_moderasi === 'Spam');
    } else if (filter === 'approved') {
      filteredKomentar = allKomentar.filter(k => k.status_moderasi === 'Approved');
    }

    renderKomentar();
  }

  function renderKomentar() {
    const container = document.getElementById('komentarContainer');

    if (!filteredKomentar || filteredKomentar.length === 0) {
      container.innerHTML = `
        <div class="empty-state">
          <div class="ico">💬</div>
          <p>Tidak ada komentar untuk ditampilkan.</p>
        </div>
      `;
      return;
    }

    container.innerHTML = filteredKomentar.map(komentar => {
      const inicial = (komentar.nama || 'A')[0].toUpperCase();
      const bgColor = ['#cc0000', '#1a3a7a', '#1a7a3c', '#b86200'][Math.floor(Math.random() * 4)];
      const statusColor = komentar.status_moderasi === 'Approved' ? 'b-ok' :
                         (komentar.status_moderasi === 'Spam' ? 'b-spam' : 'b-review');
      const statusIcon = komentar.status_moderasi === 'Approved' ? '✓ OK' :
                        (komentar.status_moderasi === 'Spam' ? '⚠ Spam' : '⏳ Pending');

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
            <div class="cmt-user">${komentar.nama || 'Anonim'}
              <span class="badge ${statusColor}" style="margin-left:6px;">${statusIcon}</span>
            </div>
            <div class="cmt-article">Pada: "${komentar.berita?.judul_berita || 'Berita tidak ditemukan'}"</div>
            <div class="cmt-text">${komentar.isi_komentar}</div>
            <div class="cmt-time">${tanggal}, ${waktu}</div>
            <div class="cmt-acts">
              ${komentar.status_moderasi !== 'Approved' ? `
                <button class="btn btn-ghost btn-sm" onclick="ubahStatusKomentar(${komentar.id}, 'Approved')">✓ Setujui</button>
              ` : ''}
              ${komentar.status_moderasi !== 'Spam' ? `
                <button class="btn btn-sm" style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;" onclick="ubahStatusKomentar(${komentar.id}, 'Spam')">⚠ Tandai Spam</button>
              ` : ''}
              <button class="btn btn-sm" style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;" onclick="hapusKomentar(${komentar.id})">🗑 Hapus</button>
            </div>
          </div>
        </div>
      `;
    }).join('');
  }

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
