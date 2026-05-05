$(document).ready(function () {
    // 1. Inisiasi Smart Notifikasi
    if (typeof SmartNotif !== "undefined") {
        SmartNotif.init({});
    }

    // 2. Auto-Active Sidebar Menu
    const currentPath = window.location.pathname;
    $(".s-item").removeClass("active");
    
    $(".s-item").each(function () {
        const link = $(this).attr("href");
        if (link === "/") {
            if (currentPath === "/") $(this).addClass("active");
        } else if (link && currentPath.includes(link)) {
            $(this).addClass("active");
        }
        // HAPUS pemanggilan badge dari dalam loop ini!
    });

    // 3. Panggil update badge SEKALI SAJA dan HANYA JIKA elemennya ada di halaman
    if ($('#badgePendingKomentar').length > 0) {
        updateGlobalKomentarBadge();
    }
    if ($('#badgeUnpaidFinance').length > 0) {
        updateGlobalFinanceBadge();
    }

    if ($('#pendingCount').length > 0) {
        updateGlobalRedaksiBadge();
    }
});

// Global fungsi untuk toggle show/hide password
$(document).on('click', '.toggle-password', function() {
    $(this).toggleClass('fa-eye fa-eye-slash');
    // Cari inputan yang sejajar sama ikon ini
    let input = $(this).siblings('input');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
    } else {
        input.attr('type', 'password');
    }
});

function updateGlobalRedaksiBadge() {
    $.ajax({
        url: '/api/redaksi/getNotifikasi', // Nembak ke API notifikasi karena isinya berita Pending
        type: 'GET',
        success: function(res) {
            if (res.status === 'success') {
                const count = res.data.length;
                const badge = $('#pendingCount');
                
                if (count > 0) {
                    badge.text(count).show(); // Tampilkan angka kalau > 0
                } else {
                    badge.hide(); // Sembunyikan kalau 0 biar rapi
                }
            }
        },
        error: function(err) {
            console.error("Gagal load badge redaksi", err);
        }
    });
}

function updateGlobalKomentarBadge() {
    $.ajax({
        url: '/api/admin/manajemen_komentar/ambilData?status=Pending',
        type: 'GET',
        success: function(res) {
            if (res.status === 'success') {
                const count = res.data.length;
                const badge = $('#badgePendingKomentar');

                if (count > 0) {
                    badge.text(count).show(); // Tampilkan angka kalau > 0
                } else {
                    badge.hide(); // Sembunyikan kalau 0
                }
            }
        },
        error: function(err) {
            console.error("Gagal load badge komentar", err);
        }
    });
}

function updateGlobalFinanceBadge() {
    $.ajax({
        url: '/api/admin/tracking_pembayaran/ambilData?status=Unpaid',
        type: 'GET',
        success: function(res) {
            if (res.status === 'success') {
                const count = res.data.length;
                const badge = $('#badgeUnpaidFinance');

                if (count > 0) {
                    badge.text(count).show();
                } else {
                    badge.hide();
                }
            }
        },
        error: function(err) {
            console.error("Gagal load badge finansial", err);
        }
    });
}

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
