/* ==========================================
   TUGAS: Mengatur Buka/Tutup Modal secara Global & Interaktif
   ========================================== */

const ModalManager = {
    // Fungsi buka modal
    open: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Munculin modal (di desain lu pakai flex)
            modal.style.display = 'flex';

            // Pasang pendeteksi klik di luar kotak putih (backdrop) sekali aja
            if (!modal.dataset.initialized) {
                modal.addEventListener('click', function(e) {
                    // Kalau yang diklik persis elemen luar (bukan isinya), tutup modal
                    if (e.target === modal) {
                        ModalManager.close(modalId);
                    }
                });
                modal.dataset.initialized = "true";
            }
        } else {
            console.warn(`Modal dengan id '${modalId}' ga ketemu cuy!`);
        }
    },

    // Fungsi tutup modal
    close: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }
};
