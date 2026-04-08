/* ==========================================
   TUGAS: Mengubah elemen biasa jadi area Drag & Drop file gambar
   ========================================== */

class ImageDropZone {
    constructor(config) {
        this.dropArea = document.querySelector(config.dropZoneSelector);
        this.fileInput = document.querySelector(config.inputSelector);
        this.previewTarget = document.querySelector(config.previewSelector);
        this.uiToHide = document.querySelectorAll(config.uiToHideSelector);

        // Kalau elemen nggak ada di halaman, stop eksekusi biar ga error
        if (!this.dropArea || !this.fileInput) return;

        this.initEvents();
    }

    initEvents() {
        // 1. Mencegah browser membuka file langsung di tab baru
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            this.dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        // 2. Tambah efek visual (CSS: drag-over) saat diseret ke area
        ['dragenter', 'dragover'].forEach(eventName => {
            this.dropArea.addEventListener(eventName, () => {
                this.dropArea.classList.add('drag-over');
            }, false);
        });

        // 3. Hilangkan efek visual saat gambar keluar area
        ['dragleave', 'drop'].forEach(eventName => {
            this.dropArea.addEventListener(eventName, () => {
                this.dropArea.classList.remove('drag-over');
            }, false);
        });

        // 4. Tangkap file saat di-drop
        this.dropArea.addEventListener('drop', (e) => {
            let dt = e.dataTransfer;
            let files = dt.files;

            if (files && files.length > 0) {
                this.fileInput.files = files; // Inject ke input type="file"
                this.handlePreview(files[0]);
            }
        });

        // 5. Tangkap juga kalau user milih lewat klik manual (onchange)
        this.fileInput.addEventListener('change', (e) => {
            if (this.fileInput.files && this.fileInput.files.length > 0) {
                this.handlePreview(this.fileInput.files[0]);
            }
        });
    }

    handlePreview(file) {
        if (!this.previewTarget || !file) return;

        let reader = new FileReader();
        reader.onload = (e) => {
            // Tampilkan gambar
            this.previewTarget.src = e.target.result;
            this.previewTarget.style.display = 'block';

            // Sembunyikan icon/text tulisan "Pilih file"
            if (this.uiToHide) {
                this.uiToHide.forEach(el => el.style.display = 'none');
            }
        }
        reader.readAsDataURL(file);
    }
}
