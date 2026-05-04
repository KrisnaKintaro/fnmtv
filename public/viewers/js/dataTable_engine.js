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

        // Callback Rendering
        this.renderRowHTML = config.renderRowHTML;

        // Custom Logic Holders
        this.customFilterLogic = null;
        this.customSortLogic = null;

        // 🌟 FITUR BARU: Otomatis nampilin loading saat di-inisialisasi
        this.showLoading();
    }

    // 🌟 FUNGSI BARU: Animasi Loading Jam Pasir
    showLoading() {
        if (!this.tbody) return;

        // Ambil jumlah kolom tabel biar colspan-nya nutupin seluruh lebar tabel
        let colCount = 1;
        if (this.tbody.parentElement && this.tbody.parentElement.tagName === 'TABLE') {
            const headerRow = this.tbody.parentElement.querySelector('thead tr');
            if (headerRow) colCount = headerRow.children.length;
        }

        // Kalau tbody ada di dalam tabel (tr/td), kalau pakai div (kayak di komentar) pakai div biasa
        if (this.tbody.tagName === 'TBODY') {
            this.tbody.innerHTML = `
                <tr>
                    <td colspan="${colCount}" style="padding: 60px 20px; text-align: center; color: var(--muted);">
                        <div style="font-size: 40px; margin-bottom: 12px; animation: pulse 1.5s infinite;">⏳</div>
                        <div style="font-weight: 600; font-size: 16px; color: var(--text);">Mengambil Data...</div>
                        <div style="font-size: 13px; margin-top: 6px;">Sedang memproses data dari server, mohon tunggu sebentar.</div>
                    </td>
                </tr>
            `;
        } else {
            this.tbody.innerHTML = `
                <div style="padding: 60px 20px; text-align: center; color: var(--muted);">
                    <div style="font-size: 40px; margin-bottom: 12px; animation: pulse 1.5s infinite;">⏳</div>
                    <div style="font-weight: 600; font-size: 16px; color: var(--text);">Mengambil Data...</div>
                    <div style="font-size: 13px; margin-top: 6px;">Sedang memproses data dari server, mohon tunggu sebentar.</div>
                </div>
            `;
        }

        // Sisipin keyframes pulse kalau belum ada di halaman
        if (!document.getElementById('dt-pulse-style')) {
            const style = document.createElement('style');
            style.id = 'dt-pulse-style';
            style.innerHTML = `@keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }`;
            document.head.appendChild(style);
        }
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
        this.currentPage = 1;
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

        if (this.customFilterLogic) {
            this.dataTerfilter = this.dataTerfilter.filter(this.customFilterLogic);
        }

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

        if (this.currentPage > totalPages && totalPages > 0) this.currentPage = totalPages;

        const startIdx = (this.currentPage - 1) * this.perPage;
        const endIdx = startIdx + this.perPage;
        const paginatedData = this.dataTerfilter.slice(startIdx, endIdx);

        let rowsHtml = '';
        paginatedData.forEach((item, index) => {
            rowsHtml += this.renderRowHTML(item, index);
        });

        this.tbody.innerHTML = rowsHtml;

        if (totalData === 0) {
            if (this.emptyState) this.emptyState.style.display = 'block';
            this.tbody.innerHTML = '';
        } else {
            if (this.emptyState) this.emptyState.style.display = 'none';
        }

        if (this.infoWrapper) {
            this.infoWrapper.textContent = `Menampilkan ${paginatedData.length} dari ${totalData} data`;
        }

        this.renderPaginationButtons(totalPages);
    }

    // 6. Render Tombol Pagination (Yang Udah Cerdas)
    renderPaginationButtons(totalPages) {
        if (!this.pagerWrapper) return;
        let html = '';

        if (totalPages > 1) {
            let maxButtons = 10;
            let startPage = Math.max(1, this.currentPage - Math.floor(maxButtons / 2));
            let endPage = startPage + maxButtons - 1;

            if (endPage > totalPages) {
                endPage = totalPages;
                startPage = Math.max(1, endPage - maxButtons + 1);
            }

            if (this.currentPage > 1) {
                html += `<div class="pg-btn" data-page="${this.currentPage - 1}">&laquo; Prev</div>`;
            }

            for (let i = startPage; i <= endPage; i++) {
                html += `<div class="pg-btn ${i === this.currentPage ? 'active' : ''}" data-page="${i}">${i}</div>`;
            }

            if (this.currentPage < totalPages) {
                html += `<div class="pg-btn" data-page="${this.currentPage + 1}">Next &raquo;</div>`;
            }
        }

        this.pagerWrapper.innerHTML = html;

        const btns = this.pagerWrapper.querySelectorAll('.pg-btn');
        btns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.currentPage = parseInt(e.target.getAttribute('data-page'));
                this.render();
            });
        });
    }
}
