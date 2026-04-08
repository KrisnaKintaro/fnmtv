@extends('Admin.master_admin')
@section('css')
<style>
    .finance-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        margin-bottom: 16px;
        justify-content: space-between;
    }

    .filter-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }
</style>
@endsection
@section('konten')
<div id="page-finance" class="page active">

    <div class="section-title">Administrasi Finansial</div>

    <div class="finance-grid">
        <div class="fin-card">
            <div class="fin-ico">💰</div>
            <div class="fin-val fin-green" id="statTotal">Rp 0</div>
            <div class="fin-lbl">Total Estimasi Omset</div> </div>
        <div class="fin-card">
            <div class="fin-ico">✅</div>
            <div class="fin-val fin-green" id="statPaid">Rp 0</div>
            <div class="fin-lbl">Sudah Dibayar (Paid)</div>
        </div>
        <div class="fin-card">
            <div class="fin-ico">⏳</div>
            <div class="fin-val fin-orange" id="statUnpaid">Rp 0</div>
            <div class="fin-lbl">Belum Dibayar (Unpaid)</div>
        </div>
    </div>

    <div class="finance-filters">
        <div class="filter-group">
            <select class="filter-select" id="filterStatus" onchange="terapkanFilterLokal()">
                <option value="all">Semua Status</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>
        </div>

        <div class="filter-group">
            <select class="filter-select" id="filterBulan" onchange="terapkanFilterLokal()">
                <option value="">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>

            <select class="filter-select" id="filterTahun" onchange="terapkanFilterLokal()">
            </select>

            <button class="btn btn-outline btn-sm" style="border-color: var(--blue); color: var(--blue); font-weight: 600;" onclick="resetFilterWaktu()">♾️ All Time</button>
        </div>
    </div>

    <div class="card">
        <div class="card-hd">
            <div class="card-ht">Daftar Transaksi Pendapatan</div>
            <div class="card-hm" id="financeCount">Memuat data...</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Judul Artikel</th>
                    <th>Penulis</th>
                    <th>Nominal</th>
                    <th>Status Bayar</th>
                    <th>Tgl Bayar</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="financeBody">
            </tbody>
        </table>

        <div class="empty-state" id="emptyFinance" style="display:none;">
            <div class="ico">💸</div>
            <p>Belum ada data pendapatan untuk filter ini.</p>
        </div>

        <div class="pager">
            <div id="financePagination" style="display:flex; gap:4px;"></div>
            <div class="pg-info" id="financeInfo">Menampilkan 0 dari 0 transaksi</div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="modalEditNominal" style="display:none;">
    <div class="modal" style="max-width:400px;">
        <div class="modal-hd">
            <div class="modal-title">Input / Edit Nominal</div>
        </div>
        <div class="modal-body">
            <div class="field">
                <label>Judul Artikel</label>
                <input type="text" id="editJudulArtikel" disabled style="background:#f5f5f5; color:#777;">
            </div>
            <div class="field">
                <label>Nominal Pendapatan (Rp)</label>
                <input type="number" id="editNominalValue" placeholder="Contoh: 750000" min="0">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:16px;">
                <button class="btn btn-outline" onclick="ModalManager.close('modalEditNominal')">Batal</button>
                <button class="btn btn-red" onclick="simpanNominal()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="modalUbahStatus" style="display:none;">
    <div class="modal" style="max-width:350px; text-align:center; padding:30px;">
        <div style="font-size:40px; margin-bottom:10px;">🔄</div>
        <h3 style="margin-bottom:10px;">Ubah Status Pembayaran?</h3>
        <p style="font-size:13px; color:var(--muted); margin-bottom:24px;">Status akan ditukar menjadi <b id="teksStatusTujuan">Paid</b>.</p>
        <div style="display:flex; gap:10px;">
            <button class="btn btn-outline" style="flex:1;" onclick="ModalManager.close('modalUbahStatus')">Batal</button>
            <button class="btn btn-red" style="flex:1;" onclick="eksekusiUbahStatus()">Ya, Ubah</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // DATA DUMMY AWAL (Ada yg nominalnya Rp 0 biar bisa dites)
    let financeDB = [
        {
            id: 1, berita_id: 101, user_id: 5, nominal_pendapatan: 750000, status_pembayaran: "Paid", waktu_pembayaran: "2026-03-10T10:00:00.000000Z",
            berita: { id: 101, judul_berita: "Pemerintah Umumkan Kebijakan Baru..." }, user: { id: 5, username: "Budi S." }
        },
        {
            id: 2, berita_id: 102, user_id: 6, nominal_pendapatan: 0, status_pembayaran: "Unpaid", waktu_pembayaran: null,
            berita: { id: 102, judul_berita: "Timnas Garuda Menang Telak 3-0" }, user: { id: 6, username: "Rina A." }
        },
        {
            id: 3, berita_id: 103, user_id: 7, nominal_pendapatan: 400000, status_pembayaran: "Paid", waktu_pembayaran: "2026-02-09T14:30:00.000000Z",
            berita: { id: 103, judul_berita: "Film Indonesia Raih Penghargaan Berlin" }, user: { id: 7, username: "Sari M." }
        },
        {
            id: 4, berita_id: 104, user_id: 8, nominal_pendapatan: 0, status_pembayaran: "Unpaid", waktu_pembayaran: null,
            berita: { id: 104, judul_berita: "Rupiah Menguat Terhadap Dolar AS" }, user: { id: 8, username: "Arif W." }
        }
    ];

    let ubahStatusTargetId = null;
    let ubahStatusTargetVal = null;
    let editFinanceId = null; // Penampung ID untuk edit nominal

    // --- INISIALISASI DATATABLE ENGINE ---
    const financeTable = new DataTableEngine({
        tableBody: '#financeBody',
        paginationWrapper: '#financePagination',
        infoWrapper: '#financeInfo',
        emptyState: '#emptyFinance',
        perPage: 5,
        renderRowHTML: function(val) {
            const judul = val.berita ? val.berita.judul_berita : 'Artikel Terhapus';
            const penulis = val.user ? val.user.username : 'Unknown';
            const nominal = 'Rp ' + parseInt(val.nominal_pendapatan).toLocaleString('id-ID');
            const isPaid = val.status_pembayaran === 'Paid';
            const badge = isPaid ? '<span class="badge b-paid">✓ Paid</span>' : '<span class="badge b-unpaid">⏳ Unpaid</span>';
            const tgl = val.waktu_pembayaran ? new Date(val.waktu_pembayaran).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', year: 'numeric'
            }) : '-';

            // Kalau nominal masih 0, kita kasih warna merah biar admin ngeh!
            const nominalWarna = val.nominal_pendapatan == 0 ? 'color:var(--red);' : 'color:var(--text);';

            return `
            <tr>
                <td><div class="tbl-title">${judul}</div></td>
                <td style="font-size:12px;color:var(--muted)">${penulis}</td>
                <td style="font-family:'JetBrains Mono';font-size:13px;font-weight:600;${nominalWarna}">${nominal}</td>
                <td>${badge}</td>
                <td style="font-size:12px;color:var(--muted)">${tgl}</td>
                <td>
                    <div class="act-btns" style="justify-content:center;">
                        <div class="ico-btn" title="Input / Edit Nominal" onclick="bukaModalEditNominal(${val.id})">✏️</div>
                        <div class="ico-btn" title="Ubah Status Pembayaran" onclick="konfirmasiUbahStatus(${val.id}, '${val.status_pembayaran}')">🔄</div>
                    </div>
                </td>
            </tr>`;
        }
    });

    $(document).ready(function() {
        $('#tbTitle').text('Administrasi Finansial');
        $('#tbCrumb').text('Admin / Finansial');
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.placeholder = 'Cari judul artikel atau penulis...';
            searchInput.value = '';
            searchInput.onkeyup = function() { terapkanFilterLokal(); };
        }

        generateTahunDropdown();

        updateSidebarBadge(financeDB);
        terapkanFilterLokal();
    });

    // --- FUNGSI UPDATE BADGE SIDEBAR ---
    function updateSidebarBadge(dataArray) {
        const totalUnpaid = dataArray.filter(x => x.status_pembayaran === 'Unpaid').length;
        const badgeEl = document.getElementById('badgeUnpaidFinance');
        if (badgeEl) badgeEl.innerText = totalUnpaid;
    }

    // --- FUNGSI GENERATE TAHUN (Otomatis dari 2026 s/d Sekarang) ---
    function generateTahunDropdown() {
        const selectTahun = document.getElementById('filterTahun');
        const currentYear = new Date().getFullYear();
        const startYear = 2026;
        let options = '<option value="">Semua Tahun</option>';
        for (let y = currentYear; y >= startYear; y--) {
            options += `<option value="${y}">${y}</option>`;
        }
        selectTahun.innerHTML = options;
    }

    function resetFilterWaktu() {
        document.getElementById('filterBulan').value = '';
        document.getElementById('filterTahun').value = '';
        document.getElementById('filterStatus').value = 'all';
        if(document.getElementById('searchInput')) document.getElementById('searchInput').value = '';
        terapkanFilterLokal();
        Toast.show('success', 'Menampilkan semua waktu (All Time)');
    }

    // --- FILTER ARRAY & STATS ---
    function terapkanFilterLokal() {
        const keyword = (document.getElementById('searchInput')?.value || '').toLowerCase();
        const statusSelected = document.getElementById('filterStatus').value;
        const bulanSelected = document.getElementById('filterBulan').value;
        const tahunSelected = document.getElementById('filterTahun').value;

        const filteredDB = financeDB.filter((val) => {
            const judul = (val.berita ? val.berita.judul_berita : '').toLowerCase();
            const penulis = (val.user ? val.user.username : '').toLowerCase();
            const matchSearch = !keyword || judul.includes(keyword) || penulis.includes(keyword);
            const matchStatus = (statusSelected === 'all') || (val.status_pembayaran === statusSelected);

            let matchBulan = true;
            let matchTahun = true;

            if (bulanSelected || tahunSelected) {
                if (val.waktu_pembayaran) {
                    const date = new Date(val.waktu_pembayaran);
                    if (bulanSelected) matchBulan = (date.getMonth() + 1).toString() === bulanSelected;
                    if (tahunSelected) matchTahun = date.getFullYear().toString() === tahunSelected;
                } else {
                    matchBulan = bulanSelected ? false : true;
                    matchTahun = tahunSelected ? false : true;
                }
            }
            return matchSearch && matchStatus && matchBulan && matchTahun;
        });

        financeTable.loadData(filteredDB);
        hitungStats(filteredDB);
    }

    function hitungStats(data) {
        let totalOmset = 0, paid = 0, unpaid = 0;

        data.forEach(item => {
            let nom = parseInt(item.nominal_pendapatan) || 0;

            totalOmset += nom; // Masukin semua duit (Paid + Unpaid) ke omset kotor

            if (item.status_pembayaran === 'Paid') {
                paid += nom;
            } else {
                unpaid += nom;
            }
        });

        document.getElementById('statTotal').innerText = 'Rp ' + totalOmset.toLocaleString('id-ID');
        document.getElementById('statPaid').innerText = 'Rp ' + paid.toLocaleString('id-ID');
        document.getElementById('statUnpaid').innerText = 'Rp ' + unpaid.toLocaleString('id-ID');
        document.getElementById('financeCount').innerText = `Menampilkan ${data.length} transaksi`;
    }

    // ==========================================
    // FUNGSI BARU: EDIT NOMINAL SAJA
    // ==========================================
    function bukaModalEditNominal(id) {
        const data = financeDB.find(x => x.id === id);
        if(data) {
            editFinanceId = id;
            document.getElementById('editJudulArtikel').value = data.berita ? data.berita.judul_berita : 'Artikel Terhapus';
            // Set input ke angka nominal saat ini (kalo 0 ya bakal tampil kosong/0)
            document.getElementById('editNominalValue').value = data.nominal_pendapatan > 0 ? data.nominal_pendapatan : '';
            ModalManager.open('modalEditNominal');
        }
    }

    function simpanNominal() {
        const nominalBaru = parseInt(document.getElementById('editNominalValue').value) || 0;
        const data = financeDB.find(x => x.id === editFinanceId);

        if(data) {
            // Simulasi API Backend (Nanti diganti pake $.ajax PATCH ke TrackingPembayaranController)
            console.log(`[API POST] Update Nominal ID ${data.berita_id} jadi Rp ${nominalBaru}`);

            // Update UI Lokal
            data.nominal_pendapatan = nominalBaru;

            // Refresh tabel & hitung ulang Stats Card
            terapkanFilterLokal();

            Toast.show('success', 'Nominal pendapatan berhasil diperbarui!');
            ModalManager.close('modalEditNominal');
        }
    }
    // ==========================================

    // --- FUNGSI UBAH STATUS CEPAT ---
    function konfirmasiUbahStatus(id, currentStatus) {
        ubahStatusTargetId = id;
        ubahStatusTargetVal = currentStatus === 'Paid' ? 'Unpaid' : 'Paid';

        document.getElementById('teksStatusTujuan').textContent = ubahStatusTargetVal;
        ModalManager.open('modalUbahStatus');
    }

    function eksekusiUbahStatus() {
        const data = financeDB.find(x => x.id === ubahStatusTargetId);
        if (data) {
            // Validasi: Gabisa di-Paid kalau nominalnya masih 0
            if (ubahStatusTargetVal === 'Paid' && (!data.nominal_pendapatan || data.nominal_pendapatan <= 0)) {
                Toast.show('warning', 'Isi nominal pendapatannya dulu sebelum di-Paid!');
                ModalManager.close('modalUbahStatus');
                return;
            }

            data.status_pembayaran = ubahStatusTargetVal;
            if (ubahStatusTargetVal === 'Paid') data.waktu_pembayaran = new Date().toISOString();
            else data.waktu_pembayaran = null;

            terapkanFilterLokal();
            updateSidebarBadge(financeDB);
            Toast.show('success', 'Status berhasil diubah!');
            ModalManager.close('modalUbahStatus');
        }
    }
</script>
@endsection
