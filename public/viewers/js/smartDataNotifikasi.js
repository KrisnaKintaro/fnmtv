/* ==========================================
   TUGAS: Engine Universal untuk Toggle & Fetch Data Notifikasi
   ========================================== */

const SmartNotif = {
    config: {
        apiUrl: null, // URL API masing-masing role
        renderItemHTML: null, // Fungsi template HTML dari halaman
    },
    initialized: false,

    init: function (setupConfig) {
        // Gabungkan config bawaan dengan config dari halaman
        this.config = { ...this.config, ...setupConfig };

        const icon = document.querySelector(".tb-icon");
        const panel = document.getElementById("notifPanel");

        if (!icon || !panel) return;

        // Cegah event listener ganda kalau dipanggil ulang
        if (!this.initialized) {
            icon.addEventListener("click", (e) => {
                e.stopPropagation();
                panel.classList.toggle("open");
            });

            document.addEventListener("click", (e) => {
                if (
                    !e.target.closest(".notif-panel") &&
                    !e.target.closest(".tb-icon")
                ) {
                    panel.classList.remove("open");
                }
            });
            this.initialized = true;
        }

        // Kalau ada URL API-nya, langsung panggil
        if (this.config.apiUrl) {
            this.fetch();
        }
    },

    fetch: function () {
        if (!this.config.apiUrl) return;

        $.get(this.config.apiUrl, (res) => {
            if (res.status === "success") {
                this.render(res.data);
            }
        }).fail(() => console.error("Gagal load data notifikasi cuy!"));
    },

    render: function(data = []) {
        const container = document.getElementById('notifPanel');
        const dot = document.querySelector('.tb-dot');
        if (!container) return;

        const count = data.length;

        // 1. Urus Lingkaran Merah (Counter)
        if (dot) {
            dot.style.display = count > 0 ? 'flex' : 'none';
            dot.textContent = count;
        }

        // 2. Render Header (Kasih sticky & background putih biar ga ketimpa teks pas di-scroll)
        let html = `<div class="notif-head" style="position: sticky; top: 0; background: var(--white, #fff); z-index: 10; border-bottom: 1px solid #eee;">
                        Notifikasi <span style="color:var(--red);">(${count})</span>
                    </div>`;

        // 3. Render Isi (BUNGKUS PAKAI DIV SCROLLER)
        html += `<div class="notif-body" style="max-height: 350px; overflow-y: auto;">`;

        if (count === 0) {
            html += `<div style="padding:20px; text-align:center; color:var(--muted); font-size:12px;">Belum ada kabar baru buat lu cuy.</div>`;
        } else {
            // Loop data dan panggil fungsi render buatan halaman lu
            data.forEach((item, index) => {
                if (typeof this.config.renderItemHTML === 'function') {
                    html += this.config.renderItemHTML(item, index);
                }
            });
        }

        html += `</div>`; // Tutup bungkus scroller

        container.innerHTML = html;

        // Pastikan container utama tidak punya padding yang bikin layout scroll aneh (opsional)
        container.style.padding = "0";
        container.style.overflow = "hidden"; // Biar sudut melengkung border-radius ga ketabrak
    }
};
