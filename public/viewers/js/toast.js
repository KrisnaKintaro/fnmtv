/* ==========================================
   FILE: public/admin/js/toast.js
   TUGAS: Mengatur Notifikasi Pop-up Global
   ========================================== */

const Toast = {
    timer: null,

    show: function(type, msg) {
        clearTimeout(this.timer);

        const toastEl = document.getElementById('toast');
        const icoEl = document.getElementById('toastIco');
        const msgEl = document.getElementById('toastMsg');

        // Pengaman kalau elemen html-nya belum dipasang di halaman
        if (!toastEl || !icoEl || !msgEl) {
            console.warn("HTML Toast belum ditambahkan di halaman ini cuy!");
            alert(msg); // Fallback pake alert biasa
            return;
        }

        // Set warna dan ikon berdasarkan tipe
        if (type === 'success') {
            icoEl.textContent = '✅';
            toastEl.style.background = '#1a7a3c'; // Hijau
        } else if (type === 'error') {
            icoEl.textContent = '❌';
            toastEl.style.background = '#cc0000'; // Merah
        } else if (type === 'warning') {
            icoEl.textContent = '⚠️';
            toastEl.style.background = '#b86200'; // Orange
        } else if (type === 'info') {
            icoEl.textContent = 'ℹ️';
            toastEl.style.background = '#0d6efd'; // Biru info
        } else {
            icoEl.textContent = '💬';
            toastEl.style.background = '#1a1a1a'; // Default
        }

        msgEl.innerText = msg;

        // Munculin Toast
        toastEl.style.display = 'flex';
        setTimeout(() => {
            toastEl.style.opacity = '1';
        }, 10);

        // Hilangkan otomatis setelah 3.5 detik
        this.timer = setTimeout(() => {
            toastEl.style.opacity = '0';
            setTimeout(() => {
                toastEl.style.display = 'none';
            }, 300);
        }, 3500);
    }
};
