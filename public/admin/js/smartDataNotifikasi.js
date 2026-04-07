/* ==========================================
   FILE: public/admin/js/smartDataNotifikasi.js
   TUGAS: Mengatur Toggle Panel & Render Data Notifikasi Global
   ========================================== */

const SmartNotif = {
    // 1. Inisialisasi Event Click (Toggle & Backdrop)
    init: function() {
        const icon = document.querySelector('.tb-icon');
        const panel = document.getElementById('notifPanel');

        if (!icon || !panel) return;

        // Event Klik Ikon Lonceng
        icon.addEventListener('click', (e) => {
            e.stopPropagation();
            panel.classList.toggle('open');
        });

        // Event Klik di Luar Panel (Auto-Close)
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.notif-panel') && !e.target.closest('.tb-icon')) {
                panel.classList.remove('open');
            }
        });
    },

    // 2. Fungsi untuk Render List Notifikasi (Bisa dipanggil setelah fetch API)
    render: function(dataNotif = []) {
        const container = document.querySelector('.notif-panel');
        const dot = document.querySelector('.tb-dot');
        if (!container) return;

        // Update jumlah notifikasi di header panel
        const count = dataNotif.length;
        let html = `<div class="notif-head">Notifikasi <span style="color:var(--red);">(${count})</span></div>`;

        if (count === 0) {
            html += `<div style="padding:20px; text-align:center; color:var(--muted); font-size:12px;">Tidak ada notifikasi baru</div>`;
            if (dot) dot.style.display = 'none';
        } else {
            if (dot) dot.style.display = 'block';

            // Loop data notifikasi
            dataNotif.forEach(item => {
                const ico = item.type === 'error' ? '❌' : '✅';
                html += `
                    <div class="notif-item">
                        <div class="notif-ico">${ico}</div>
                        <div class="notif-txt">
                            <div class="notif-msg">${item.message}</div>
                            <div class="notif-t">${item.time}</div>
                        </div>
                    </div>
                `;
            });
        }

        container.innerHTML = html;
    }
};

// Jalankan init otomatis saat dokumen siap
$(document).ready(() => SmartNotif.init());
