@extends('admin.master_admin')
@section('css')
    <style>
        /* Styling khusus grid statistik di dashboard */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, .08);
        }

        /* Aksen garis warna di bawah card */
        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--c, var(--red));
        }

        /* Variasi warna card berdasarkan urutan */
        .stat-card:nth-child(2) {
            --c: #1a3a7a;
        }

        .stat-card:nth-child(3) {
            --c: #1a7a3c;
        }

        .stat-card:nth-child(4) {
            --c: #b86200;
        }

        /* Layout dua kolom bawah (Chart & Revenue) */
        .two-col-dash {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Mockup Chart Bar sederhana */
        .chart-area {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px 24px;
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            height: 120px;
        }

        .bar-fill {
            width: 100%;
            background: var(--red);
            border-radius: 3px 3px 0 0;
            opacity: .85;
            transition: opacity .2s;
        }
    </style>
@endsection
@section('konten')
@endsection
@section('js')
    <script>
        // JS spesifik dashboard
        console.log("Dashboard Loaded");

        // Contoh interaksi sederhana: Menampilkan nilai saat bar chart di-hover
        document.querySelectorAll('.bar-fill').forEach(bar => {
            bar.addEventListener('mouseenter', function() {
                this.style.opacity = '1';
            });
            bar.addEventListener('mouseleave', function() {
                this.style.opacity = '0.85';
            });
        });

        // Kamu bisa menambahkan logic Chart.js atau library lain di sini nanti
    </script>
@endsection
