$(document).ready(function () {
    // 1. Inisiasi Smart Notifikasi (tanpa API dulu biar loncengnya bisa buka-tutup)
    if (typeof SmartNotif !== "undefined") {
        SmartNotif.init({});
    }

    // 2. Auto-Active Sidebar Menu berdasarkan URL
    const currentPath = window.location.pathname;

    // Matikan semua tombol aktif bawaan dari HTML
    $(".s-item").removeClass("active");

    // Loop setiap item menu
    $(".s-item").each(function () {
        const link = $(this).attr("href");

        // Cek kecocokan URL (hindari '/' biar gak bentrok, khusus root cek exact)
        if (link === "/") {
            if (currentPath === "/") $(this).addClass("active");
        } else if (link && currentPath.includes(link)) {
            $(this).addClass("active");
        }
    });
});
/**
 * 1. NOTIFIKASI DROPDOWN (NAVBAR)
 * Mengatur buka-tutup panel notifikasi di Topbar.
 */
function toggleNotif() {
    const panel = document.getElementById("notifPanel");
    if (panel) {
        panel.classList.toggle("open");
    }
}

/**
 * 2. CLICK OUTSIDE TO CLOSE
 * Menutup dropdown notifikasi otomatis jika user klik di luar area panel.
 */
document.addEventListener("click", function (e) {
    const notifPanel = document.getElementById("notifPanel");
    const notifBtn = e.target.closest(".tb-icon"); // Tombol lonceng

    if (notifPanel && notifPanel.classList.contains("open")) {
        if (!notifPanel.contains(e.target) && !notifBtn) {
            notifPanel.classList.remove("open");
        }
    }
});

/**
 * 3. TAB PILLS / FILTER VISUAL
 * Supaya tombol filter (seperti Semua, Draft, Aktif) ada efek kliknya.
 * Kita pakai Event Delegation supaya tetap jalan kalau konten di-load via Ajax.
 */
document.addEventListener("click", function (e) {
    const tabBtn = e.target.closest(".tab-p");
    if (tabBtn) {
        const container = tabBtn.closest(".tab-pills");
        if (container) {
            container
                .querySelectorAll(".tab-p")
                .forEach((x) => x.classList.remove("active"));
            tabBtn.classList.add("active");
        }
    }
});

/**
 * 4. SIDEBAR RESPONSIVE (OPTIONAL)
 * Jika nanti kamu ingin sidebar bisa ditarik/tutup di layar kecil (mobile).
 */
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    if (sidebar) {
        sidebar.classList.toggle("mobile-open");
    }
}
