<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    @yield('css')
</head>

<body>
    @include('Admin.layout.sidebar')
    <div class="main">
        @include('Admin.layout.navbar')
        @yield('konten')
    </div>
    <script>
        /**
         * 1. NOTIFIKASI DROPDOWN (NAVBAR)
         * Mengatur buka-tutup panel notifikasi di Topbar.
         */
        function toggleNotif() {
            const panel = document.getElementById('notifPanel');
            if (panel) {
                panel.classList.toggle('open');
            }
        }

        /**
         * 2. CLICK OUTSIDE TO CLOSE
         * Menutup dropdown notifikasi otomatis jika user klik di luar area panel.
         */
        document.addEventListener('click', function(e) {
            const notifPanel = document.getElementById('notifPanel');
            const notifBtn = e.target.closest('.tb-icon'); // Tombol lonceng

            if (notifPanel && notifPanel.classList.contains('open')) {
                if (!notifPanel.contains(e.target) && !notifBtn) {
                    notifPanel.classList.remove('open');
                }
            }
        });

        /**
         * 3. TAB PILLS / FILTER VISUAL
         * Supaya tombol filter (seperti Semua, Draft, Aktif) ada efek kliknya.
         * Kita pakai Event Delegation supaya tetap jalan kalau konten di-load via Ajax.
         */
        document.addEventListener('click', function(e) {
            const tabBtn = e.target.closest('.tab-p');
            if (tabBtn) {
                const container = tabBtn.closest('.tab-pills');
                if (container) {
                    container.querySelectorAll('.tab-p').forEach(x => x.classList.remove('active'));
                    tabBtn.classList.add('active');
                }
            }
        });

        /**
         * 4. SIDEBAR RESPONSIVE (OPTIONAL)
         * Jika nanti kamu ingin sidebar bisa ditarik/tutup di layar kecil (mobile).
         */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('mobile-open');
            }
        }
        @yield('js')
    </script>
</body>

</html>
