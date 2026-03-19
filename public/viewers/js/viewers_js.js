        /**
         * 1. SEARCH OVERLAY TOGGLE
         * Muncul saat user klik icon cari di navbar/header
         */
        function toggleSearch() {
            const overlay = document.getElementById('searchResults');
            if (overlay) {
                overlay.classList.toggle('active');
                if (overlay.classList.contains('active')) {
                    document.getElementById('searchInput').focus();
                }
            }
        }

        /**
         * 2. NAV ITEM ACTIVE STATE
         * Memberikan indikator halaman mana yang sedang dibuka (visual saja)
         */
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        /**
         * 3. ESCAPE KEY TO CLOSE SEARCH
         * UX: Menutup search overlay dengan menekan tombol ESC
         */
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                const overlay = document.getElementById('searchResults');
                if (overlay) overlay.classList.remove('active');
            }
        });
