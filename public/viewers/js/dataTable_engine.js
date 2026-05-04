/* ==========================================
   TUGAS: Mengatur Search, Filter, Sort, dan Pagination secara universal
   ========================================== */

class DataTableEngine {
    constructor(config) {
        // State Data
        this.dataAsli = [];
        this.dataTerfilter = [];
        this.currentPage = 1;
        this.perPage = config.perPage || 10;

        // Element Selectors
        this.tbody = document.querySelector(config.tableBody);
        this.pagerWrapper = document.querySelector(config.paginationWrapper);
        this.infoWrapper = document.querySelector(config.infoWrapper);
        this.emptyState = document.querySelector(config.emptyState);

        // Callback Rendering (Biar tiap halaman bisa ngatur HTML tr-nya sendiri)
        this.renderRowHTML = config.renderRowHTML;

        // Custom Logic Holders
        this.customFilterLogic = null;
        this.customSortLogic = null;
    }

    // 1. Load Data Mentah dari API
    loadData(data) {
        this.dataAsli = data;
        this.currentPage = 1;
        this.process();
    }

    // 2. Set Rules untuk Filter & Search
    setFilterAndSearch(filterFunction) {
        this.customFilterLogic = filterFunction;
        this.currentPage = 1; // Balikin ke page 1 tiap kali ngefilter
        this.process();
    }

    // 3. Set Rules untuk Sorting
    setSort(sortFunction) {
        this.customSortLogic = sortFunction;
        this.process();
    }

    // 4. Mesin Pemroses Utama
    process() {
        this.dataTerfilter = [...this.dataAsli];

        // Jalankan Filter & Search
        if (this.customFilterLogic) {
            this.dataTerfilter = this.dataTerfilter.filter(this.customFilterLogic);
        }

        // Jalankan Sorting
        if (this.customSortLogic) {
            this.dataTerfilter.sort(this.customSortLogic);
        }

        this.render();
    }

    // 5. Render Data ke Tabel & Pagination
    render() {
        if (!this.tbody) return;

        const totalData = this.dataTerfilter.length;
        const totalPages = Math.ceil(totalData / this.perPage);

        // Pengaman: kalau data nyusut tapi current page di luar batas
        if (this.currentPage > totalPages && totalPages > 0) this.currentPage = totalPages;

        // Hitung index potongan
        const startIdx = (this.currentPage - 1) * this.perPage;
        const endIdx = startIdx + this.perPage;
        const paginatedData = this.dataTerfilter.slice(startIdx, endIdx);

        // Render HTML Baris
        let rowsHtml = '';
        paginatedData.forEach((item, index) => {
            // Panggil fungsi render bawaan halamannya
            rowsHtml += this.renderRowHTML(item, index);
        });

        this.tbody.innerHTML = rowsHtml;

        // Atur Tampilan Kosong
        if (totalData === 0) {
            if (this.emptyState) this.emptyState.style.display = 'block';
            this.tbody.innerHTML = '';
        } else {
            if (this.emptyState) this.emptyState.style.display = 'none';
        }

        // Update Text Info
        if (this.infoWrapper) {
            this.infoWrapper.textContent = `Menampilkan ${paginatedData.length} dari ${totalData} data`;
        }

        this.renderPaginationButtons(totalPages);
    }

    // 6. Render Tombol Pagination
    renderPaginationButtons(totalPages) {
        if (!this.pagerWrapper) return;

        let html = '';
        if (totalPages > 1) {
            const maxButtons = 10;
            let startPage = 1;
            let endPage = totalPages;

            if (totalPages > maxButtons) {
                const half = Math.floor(maxButtons / 2);
                startPage = Math.max(1, this.currentPage - half);
                endPage = startPage + maxButtons - 1;

                if (endPage > totalPages) {
                    endPage = totalPages;
                    startPage = totalPages - maxButtons + 1;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                html += `<div class="pg-btn ${i === this.currentPage ? 'active' : ''}" data-page="${i}">${i}</div>`;
            }
        }
        this.pagerWrapper.innerHTML = html;

        // Tambah event listener ke tombol yang baru dibuat
        const btns = this.pagerWrapper.querySelectorAll('.pg-btn');
        btns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.currentPage = parseInt(e.target.getAttribute('data-page'));
                this.render(); // Cuma render ulang, gak perlu process filter dari awal
            });
        });
    }

    // 7. [PENGEMBANGAN] Fitur Export / Download
    exportData(type = 'csv') {
        console.log(`Menyiapkan data untuk didownload dalam format ${type}...`);
        if(this.dataTerfilter.length === 0) {
            alert("Tidak ada data untuk diexport!");
            return;
        }

        if (type === 'csv') {
            // Nanti logikanya kita bikin di sini
            alert("Fitur Export CSV sedang dikembangkan cuy!");
        }
    }
}
