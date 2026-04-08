@extends('Admin.master_admin')

@section('css')
@endsection

@section('konten')
<div id="page-categories" class="page active">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div class="section-title" style="margin:0;">Manajemen Kategori</div>
        <button class="btn btn-red" onclick="bukaModalCat()">+ Tambah Kategori</button>
    </div>
    <div style="margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 14px; font-weight: 700; color: var(--text); letter-spacing: 0.5px; ">
            📊 Statistik & Sebaran Artikel
        </span>
        <div style="flex: 1; height: 1px; background: #eee;"></div>
    </div>

    <div class="cat-grid" id="catGridContainer">
    </div>

    <div class="card">
        <div class="card-hd">
            <div class="card-ht">Semua Kategori & Detail</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Artikel</th>
                    <th>Terakhir Diupdate</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="catBody">
            </tbody>
        </table>

        <div class="empty-state" id="emptyState" style="display:none;">
            <div class="ico">📭</div>
            <p>Belum ada kategori yang ditambahkan.</p>
        </div>
        <div class="pager">
            <div id="paginationControls" style="display:flex; gap:4px;"></div>
            <div class="pg-info" id="pagerInfo">Menampilkan 0 dari 0 kategori</div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="modalCat" style="display:none;">
    <div class="modal" style="max-width:400px; position: relative;">
        <div class="modal-hd" style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 15px; border-bottom: 1px solid #eee; position: relative;">
            <div class="modal-title" id="modalCatTitle" style="margin: 0; font-size: 18px; font-weight: 700;">Tambah Kategori</div>

            <div class="modal-close" onclick="closeModalCat()" style="
            position: absolute;
            right: -10px;    /* Lompat 10px ke kanan */
            top: -15px;      /* Lompat 15px ke atas */
            cursor: pointer;
            font-size: 22px;
            color: #999;     /* Warna abu-abu kusam biar ga norak */
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        ">✕</div>
        </div>

        <div class="modal-body">
            <div class="field">
                <label>Nama Kategori</label>
                <input type="text" id="inputNamaKategori" placeholder="Misal: Politik">
            </div>
            <div class="field">
                <label>Slug Kategori</label>
                <input type="text" id="inputSlugKategori" placeholder="misal: politik" style="font-family:'JetBrains Mono',monospace;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:16px;">
                <button class="btn btn-outline" onclick="closeModalCat()">Batal</button>
                <button class="btn btn-red" onclick="simpanKategori()">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    /* global DataTableEngine, ModalManager, Toast */
    
    // Data akan di-load dari API
    let DBCategory = [];
    let editCatId = null;

    $(document).ready(function() {
        // 1. "Bajak" Input Search di Navbar khusus untuk halaman ini
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.placeholder = 'Cari kategori...'; // Ubah placeholder
            searchInput.value = ''; // Kosongin dulu pas load

            // Hapus event listener lama (kalau ada) dan pasang yang baru
            searchInput.onkeyup = function() {
                jalankanFilter();
            };
        }

        loadDataKategoriFromAPI();
    });

    // Setup DataTable Engine
    const catTable = new DataTableEngine({
        tableBody: '#catBody',
        paginationWrapper: '#paginationControls',
        infoWrapper: '#pagerInfo',
        emptyState: '#emptyState',
        perPage: 4,
        renderRowHTML: function(val) {
            const date = new Date(val.updated_at).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', year: 'numeric'
            });

            return `
            <tr>
                <td><b>${val.nama_kategori}</b></td>
                <td style="font-family:'JetBrains Mono';font-size:12px;color:var(--muted)">${val.slug}</td>
                <td>${val.berita_count || 0}</td>
                <td style="color:var(--muted);font-size:12px">${date}</td>
                <td>
                    <div class="act-btns">
                        <div class="ico-btn" onclick="editKategori(${val.id})" title="Edit">✏️</div>
                        <div class="ico-btn" onclick="hapusKategori(${val.id})" title="Hapus">🗑</div>
                    </div>
                </td>
            </tr>`;
        }
    });

    // Load data dari API
    async function loadDataKategoriFromAPI() {
        try {
            const response = await fetch('/api/admin/manajemen_kategori/ambilData');
            const result = await response.json();
            
            if (result.status === 'success') {
                DBCategory = result.data;
                catTable.loadData(DBCategory);
                jalankanFilter();
            } else {
                Toast.show('error', 'Gagal memuat data kategori');
            }
        } catch (error) {
            console.error('Error loading categories:', error);
            Toast.show('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    // Render Grid (Kotak Atas)
    function renderCatGrid(dataToRender = DBCategory) {
        const container = document.getElementById('catGridContainer');
        let html = '';

        dataToRender.forEach(val => {
            html += `
            <div class="cat-chip">
                <div>
                    <div class="cat-name">${val.nama_kategori}</div>
                    <div class="cat-count">${val.berita_count || 0} artikel</div>
                </div>
                <div class="cat-actions">
                    <div class="ico-btn" onclick="editKategori(${val.id})">✏️</div>
                    <div class="ico-btn" onclick="hapusKategori(${val.id})">🗑</div>
                </div>
            </div>`;
        });

        // Selalu tambahkan Card 'Tambah Kategori' di urutan paling belakang
        html += `
        <div class="cat-chip" style="border-style:dashed;cursor:pointer;justify-content:center;color:var(--muted);" onclick="bukaModalCat()">
            <div style="text-align:center">
                <div style="font-size:22px;">+</div>
                <div style="font-size:12px;">Tambah Kategori</div>
            </div>
        </div>`;

        container.innerHTML = html;
    }

    // Filter Global (CARD & TABLE)
    function jalankanFilter() {
        const keyword = (document.getElementById('searchInput')?.value || '').toLowerCase();

        // 1. Filter Data Untuk Tabel via DataTableEngine
        catTable.setFilterAndSearch((val) => {
            return val.nama_kategori.toLowerCase().includes(keyword) ||
                   val.slug.toLowerCase().includes(keyword);
        });

        // 2. Filter Data Manual Untuk Grid Card di Atas
        const dataTerfilter = DBCategory.filter((val) => {
            return val.nama_kategori.toLowerCase().includes(keyword) ||
                   val.slug.toLowerCase().includes(keyword);
        });

        renderCatGrid(dataTerfilter);
    }

    // Modal & Aksi
    function bukaModalCat() {
        editCatId = null;
        document.getElementById('modalCatTitle').textContent = 'Tambah Kategori';
        document.getElementById('inputNamaKategori').value = '';
        document.getElementById('inputSlugKategori').value = '';
        ModalManager.open('modalCat');
    }

    function closeModalCat() {
        ModalManager.close('modalCat');
    }

    function editKategori(id) {
        const cat = DBCategory.find(c => c.id === id);
        if (cat) {
            editCatId = id;
            document.getElementById('modalCatTitle').textContent = 'Edit Kategori';
            document.getElementById('inputNamaKategori').value = cat.nama_kategori;
            document.getElementById('inputSlugKategori').value = cat.slug;
            ModalManager.open('modalCat');
        }
    }

    async function simpanKategori() {
        const nama = document.getElementById('inputNamaKategori').value.trim();
        
        if (!nama) {
            Toast.show('error', 'Nama kategori tidak boleh kosong!');
            return;
        }

        try {
            let url, method, payload;

            if (editCatId) {
                // Update kategori
                url = `/api/admin/manajemen_kategori/ubahData/${editCatId}`;
                method = 'PUT';
                payload = { nama_kategori: nama };
            } else {
                // Tambah kategori baru
                url = '/api/admin/manajemen_kategori/tambahData';
                method = 'POST';
                payload = { nama_kategori: nama };
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.status === 'success') {
                Toast.show('success', result.message);
                closeModalCat();
                loadDataKategoriFromAPI();
            } else {
                Toast.show('error', result.message || 'Gagal menyimpan kategori');
            }
        } catch (error) {
            console.error('Error:', error);
            Toast.show('error', 'Terjadi kesalahan saat menyimpan');
        }
    }

    async function hapusKategori(id) {
        if (confirm('Yakin ingin menghapus kategori ini? Data artikel di dalamnya mungkin terdampak.')) {
            try {
                const response = await fetch(`/api/admin/manajemen_kategori/hapusData/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const result = await response.json();

                if (result.status === 'success') {
                    Toast.show('success', result.message);
                    loadDataKategoriFromAPI();
                } else {
                    Toast.show('error', result.message || 'Gagal menghapus kategori');
                }
            } catch (error) {
                console.error('Error:', error);
                Toast.show('error', 'Terjadi kesalahan saat menghapus');
            }
        }
    }

    // AUTO-GENERATE SLUG
    document.getElementById('inputNamaKategori').addEventListener('keyup', function() {
        if (!editCatId) {
            let slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            document.getElementById('inputSlugKategori').value = slug;
        }
    });

</script>
@endsection
