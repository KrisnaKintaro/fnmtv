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
    <div id="page-dashboard" class="page active">
        <div class="section-title">Statistik Performa</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-ico">📰</div>
                <div class="stat-val">2,847</div>
                <div class="stat-lbl">Total Berita</div>
                <div class="stat-chg chg-up">▲ +14 artikel hari ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-ico">👁</div>
                <div class="stat-val">184K</div>
                <div class="stat-lbl">Total Kunjungan</div>
                <div class="stat-chg chg-up">▲ +8.3% minggu ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-ico">💰</div>
                <div class="stat-val">Rp 12,4M</div>
                <div class="stat-lbl">Total Pendapatan</div>
                <div class="stat-chg chg-up">▲ +Rp 1.2M bulan ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-ico">💬</div>
                <div class="stat-val">1,024</div>
                <div class="stat-lbl">Total Komentar</div>
                <div class="stat-chg chg-dn">▼ 12 perlu moderasi</div>
            </div>
        </div>

        <div class="two-col-dash">
            <!-- Chart Kunjungan (UC-07) -->
            <div class="chart-area">
                <div class="chart-head">
                    <div class="chart-title">Tren Kunjungan Mingguan</div>
                    <select class="filter-select" style="width:auto;padding:5px 10px;font-size:12px;">
                        <option>7 Hari Terakhir</option>
                        <option>30 Hari Terakhir</option>
                    </select>
                </div>
                <div class="chart-bars">
                    <div class="bar-col">
                        <div class="bar-val">18K</div>
                        <div class="bar-fill" style="height:60%;"></div>
                        <div class="bar-lbl">Sen</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar-val">24K</div>
                        <div class="bar-fill" style="height:80%;"></div>
                        <div class="bar-lbl">Sel</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar-val">19K</div>
                        <div class="bar-fill" style="height:63%;"></div>
                        <div class="bar-lbl">Rab</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar-val">30K</div>
                        <div class="bar-fill" style="height:100%;"></div>
                        <div class="bar-lbl">Kam</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar-val">28K</div>
                        <div class="bar-fill" style="height:93%;"></div>
                        <div class="bar-lbl">Jum</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar-val">22K</div>
                        <div class="bar-fill" style="height:73%;opacity:.5"></div>
                        <div class="bar-lbl">Sab</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar-val">43K</div>
                        <div class="bar-fill" style="height:100%;background:#1a3a7a"></div>
                        <div class="bar-lbl">Min</div>
                    </div>
                </div>
                <div class="legend">
                    <div class="leg-item">
                        <div class="leg-dot" style="background:var(--red)"></div>Hari Kerja
                    </div>
                    <div class="leg-item">
                        <div class="leg-dot" style="background:#1a3a7a"></div>Weekend
                    </div>
                </div>
            </div>
            <!-- Revenue -->
            <div class="revenue-card">
                <div class="rc-title">Ringkasan Finansial</div>
                <div style="font-size:12px;color:var(--muted);">Bulan Maret 2026</div>
                <div class="rc-total">Rp 12.400.000</div>
                <div class="rc-row"><span class="rc-label">Sudah Dibayar</span><span class="rc-val"
                        style="color:var(--success);">Rp 9.200.000</span></div>
                <div class="rc-row"><span class="rc-label">Belum Dibayar</span><span class="rc-val"
                        style="color:var(--warning);">Rp 3.200.000</span></div>
                <div class="rc-row"><span class="rc-label">Artikel Berbayar</span><span class="rc-val">38 artikel</span>
                </div>
                <div class="rc-row"><span class="rc-label">Rata-rata per Artikel</span><span class="rc-val">Rp 326K</span>
                </div>
                <button class="btn btn-outline btn-sm" style="width:100%;justify-content:center;margin-top:12px;"
                    onclick="showPage('finance',null)">Lihat Detail Finansial →</button>
            </div>
        </div>

        <!-- Recent Activity -->
        <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;">
            <div class="card">
                <div class="card-hd">
                    <div class="card-ht">Berita Terbaru Dipublikasikan</div><button class="btn btn-ghost btn-sm"
                        onclick="showPage('news-list',null)">Lihat Semua →</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="tbl-img">🏛️</div>
                                    <div>
                                        <div class="tbl-title">Pemerintah Umumkan Kebijakan Ekonomi Baru</div>
                                        <div class="tbl-meta">Budi S. • 10 Mar 2026</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge b-cat">Politik</span></td>
                            <td><span class="badge b-pub">● Terbit</span></td>
                            <td style="font-family:'JetBrains Mono';font-size:12px;">12.4K</td>
                            <td>
                                <div class="act-btns">
                                    <div class="ico-btn" title="Edit">✏️</div>
                                    <div class="ico-btn" title="Hapus">🗑</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="tbl-img">⚽</div>
                                    <div>
                                        <div class="tbl-title">Timnas Garuda Menang 3-0 Lawan Vietnam</div>
                                        <div class="tbl-meta">Rina A. • 10 Mar 2026</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge b-cat">Olahraga</span></td>
                            <td><span class="badge b-pub">● Terbit</span></td>
                            <td style="font-family:'JetBrains Mono';font-size:12px;">28.7K</td>
                            <td>
                                <div class="act-btns">
                                    <div class="ico-btn">✏️</div>
                                    <div class="ico-btn">🗑</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="tbl-img">💹</div>
                                    <div>
                                        <div class="tbl-title">IHSG Menguat Tipis di Sesi Pagi</div>
                                        <div class="tbl-meta">Arif W. • 10 Mar 2026</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge b-cat">Ekonomi</span></td>
                            <td><span class="badge b-draft">○ Draft</span></td>
                            <td style="font-family:'JetBrains Mono';font-size:12px;">—</td>
                            <td>
                                <div class="act-btns">
                                    <div class="ico-btn">✏️</div>
                                    <div class="ico-btn">🗑</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <div class="card-hd">
                    <div class="card-ht">Aktivitas Terbaru</div>
                </div>
                <div style="padding:4px 0;">
                    <div class="act-row">
                        <div class="act-dot"></div>
                        <div>
                            <div class="act-text"><strong>Budi S.</strong> menerbitkan artikel baru</div>
                            <div class="act-time">2 menit lalu</div>
                        </div>
                    </div>
                    <div class="act-row">
                        <div class="act-dot" style="background:#1a3a7a"></div>
                        <div>
                            <div class="act-text"><strong>12 komentar</strong> menunggu moderasi</div>
                            <div class="act-time">15 menit lalu</div>
                        </div>
                    </div>
                    <div class="act-row">
                        <div class="act-dot" style="background:var(--success)"></div>
                        <div>
                            <div class="act-text">Pembayaran <strong>Rp 500.000</strong> dikonfirmasi</div>
                            <div class="act-time">1 jam lalu</div>
                        </div>
                    </div>
                    <div class="act-row">
                        <div class="act-dot" style="background:var(--warning)"></div>
                        <div>
                            <div class="act-text">Rina A. mengajukan <strong>artikel ke review</strong></div>
                            <div class="act-time">3 jam lalu</div>
                        </div>
                    </div>
                    <div class="act-row">
                        <div class="act-dot"></div>
                        <div>
                            <div class="act-text">Kategori <strong>Teknologi</strong> ditambahkan</div>
                            <div class="act-time">5 jam lalu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
