@extends('Admin.master_admin')

@section('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --red: #cc0000;
            --red-dark: #990000;
            --red-light: #ff2222;
            --bg: #f5f4f0;
            --white: #ffffff;
            --surface: #ffffff;
            --surface2: #f0eeea;
            --border: #e0ddd6;
            --text: #1a1a1a;
            --muted: #7a7570;
            --success: #1a7a3c;
            --warning: #b86200;
            --blue: #1a3a7a;
        }

        body {
            background: var(--bg);
            color: var(--text);
        }

        .page-content {
            padding: 20px 24px;
        }

        .section-title {
            font-family: 'Merriweather', serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--muted);
            margin-bottom: 14px;
            margin-top: 4px;
        }

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

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--c, var(--red));
        }

        .stat-card:nth-child(2) {
            --c: #1a3a7a;
        }

        .stat-card:nth-child(3) {
            --c: #1a7a3c;
        }

        .stat-card:nth-child(4) {
            --c: #b86200;
        }

        .stat-ico {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .stat-val {
            font-family: 'Merriweather', serif;
            font-size: 26px;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-lbl {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .stat-chg {
            font-size: 11px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .chg-up {
            color: var(--success);
        }

        .chg-dn {
            color: var(--red);
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            margin-bottom: 20px;
        }

        .analytics-grid-full {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .card-hd {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-ht {
            font-family: 'Merriweather', serif;
            font-size: 14px;
            font-weight: 700;
        }

        .card-hm {
            font-size: 12px;
            color: var(--muted);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 10px 18px;
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            background: #fcfbf9;
        }

        td {
            padding: 12px 18px;
            font-size: 13px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #faf9f7;
        }

        .tbl-title {
            font-weight: 600;
            font-size: 13px;
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tbl-meta {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .b-pub {
            background: #e6f4ec;
            color: var(--success);
        }

        .b-cat {
            background: #fde8e8;
            color: var(--red);
        }

        .rank-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
            width: 28px;
            text-align: center;
        }

        .rank-1 {
            color: var(--warning);
        }

        .rank-2 {
            color: var(--muted);
        }

        .rank-3 {
            color: #8b6914;
        }

        .views-bar-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .views-bar {
            height: 6px;
            border-radius: 3px;
            background: var(--red);
            opacity: .7;
            transition: width .6s ease;
        }

        .views-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: var(--muted);
            white-space: nowrap;
        }

        .chart-area {
            padding: 20px 24px;
        }

        .chart-period {
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--muted);
            transition: .15s;
            font-family: inherit;
        }

        .chart-period.active {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }

        .chart-period:hover:not(.active) {
            border-color: var(--red);
            color: var(--red);
        }

        .chart-canvas-wrap {
            position: relative;
            height: 160px;
            margin-bottom: 12px;
        }

        .chart-canvas {
            width: 100%;
            height: 100%;
        }

        .chart-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .cs-item {
            text-align: center;
        }

        .cs-val {
            font-family: 'Merriweather', serif;
            font-size: 16px;
            font-weight: 900;
        }

        .cs-lbl {
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .eng-item {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .eng-item:last-child {
            border-bottom: none;
        }

        .eng-rank-badge {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .e-r1 {
            background: #fff3cd;
            color: var(--warning);
        }

        .e-r2 {
            background: #e8e8e8;
            color: #555;
        }

        .e-r3 {
            background: #f3e8d5;
            color: #8b6914;
        }

        .e-rn {
            background: var(--surface2);
            color: var(--muted);
        }

        .eng-content {
            flex: 1;
            min-width: 0;
        }

        .eng-title {
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 6px;
        }

        .eng-metrics {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .eng-metric {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: var(--muted);
        }

        .eng-metric span {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            color: var(--text);
        }

        .cat-perf-item {
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .cat-perf-item:last-child {
            border-bottom: none;
        }

        .cat-emoji {
            font-size: 20px;
            width: 32px;
            text-align: center;
        }

        .cat-info {
            flex: 1;
        }

        .cat-name-lbl {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .cat-bar-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cat-prog {
            flex: 1;
            height: 5px;
            background: var(--surface2);
            border-radius: 3px;
            overflow: hidden;
        }

        .cat-prog-fill {
            height: 100%;
            border-radius: 3px;
            background: var(--red);
            transition: width .8s ease;
        }

        .cat-pct {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: var(--muted);
            white-space: nowrap;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }

        .skel {
            background: var(--surface2);
            border-radius: 4px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        .skel-row {
            height: 44px;
            margin-bottom: 2px;
        }

        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .period-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--white);
        }

        .period-lbl {
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-right: 4px;
        }

        .period-btn {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid var(--border);
            background: var(--white);
            color: var(--muted);
            transition: .15s;
            font-family: inherit;
        }

        .period-btn.active {
            background: var(--text);
            color: #fff;
            border-color: var(--text);
        }

        .period-btn:hover:not(.active) {
            border-color: var(--text);
            color: var(--text);
        }

        .refresh-btn {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid var(--border);
            background: var(--white);
            color: var(--muted);
            transition: .15s;
            font-family: inherit;
        }

        .refresh-btn:hover {
            border-color: var(--red);
            color: var(--red);
        }

        .last-updated {
            font-size: 11px;
            color: var(--muted);
        }

        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: var(--text);
            color: #fff;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            z-index: 999;
            opacity: 0;
            transform: translateY(10px);
            transition: all .3s;
            pointer-events: none;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 550px; /* Tabel akan maksa munculin scrollbar kalau layarnya lebih sempit dari 550px */
        }
    </style>
@endsection

@section('konten')
    <div class="page-content">
        <!-- Period Filter -->
        <div class="period-bar">
            <span class="period-lbl">Periode:</span>
            <button class="period-btn" onclick="setPeriod('today',this)">Hari ini</button>
            <button class="period-btn active" onclick="setPeriod('week',this)">7 Hari</button>
            <button class="period-btn" onclick="setPeriod('month',this)">30 Hari</button>
            <button class="period-btn" onclick="setPeriod('year',this)">1 Tahun</button>
            <button class="period-btn" onclick="setPeriod('all',this)">Semua Tahun</button>
            <span class="last-updated" id="lastUpdated">Terakhir diperbarui: —</span>
            <button class="refresh-btn" onclick="loadAllData()">
                <svg id="refreshIcon2" width="12" height="12" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Perbarui
            </button>
        </div>

        <!-- 1. SUMMARY CARDS -->
        <div class="section-title">Ringkasan Sistem</div>
        <div class="stats-grid" id="summaryCards">
            <!-- will be filled by JS -->
        </div>

        <!-- 2. VISIT TREND -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-hd">
                <div>
                    <div class="card-ht">📈 Tren Kunjungan</div>
                    <div class="card-hm">Performa traffic website</div>
                </div>
                <div style="display:flex;gap:6px;" id="chartPeriodBtns">
                    <button class="chart-period active" onclick="switchChart('views',this)">Views</button>
                    <button class="chart-period" onclick="switchChart('visitors',this)">Pengunjung</button>
                    <button class="chart-period" onclick="switchChart('comments',this)">Komentar</button>
                </div>
            </div>
            <div class="chart-area">
                <div class="chart-canvas-wrap" style="height:180px;">
                    <canvas id="visitChart" class="chart-canvas"></canvas>
                </div>
                <div class="chart-stats-row" id="chartStatsRow">
                    <!-- filled by JS -->
                </div>
            </div>
        </div>

        <!-- 3. TOP NEWS + ENGAGEMENT -->
        <div class="analytics-grid-full">

            <!-- Top News by Views -->
            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-ht">👑 Top Berita — Paling Banyak Dilihat</div>
                        <div class="card-hm" id="topNewsSubtitle">Memuat data...</div>
                    </div>
                    <span class="badge b-pub">Live</span>
                </div>
                <div id="topNewsTable" class="table-responsive">
                    <div style="padding:20px;">
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;"></div>
                    </div>
                </div>
            </div>

            <!-- Viral / Engagement Tracker -->
            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-ht">🔥 Viral — Engagement Tracker</div>
                        <div class="card-hm" id="viralSubtitle">Memuat data...</div>
                    </div>
                    <select id="viralFilter" onchange="renderViral()"
                        style="border:1px solid var(--border);border-radius:6px;padding:5px 10px;font-size:12px;font-family:inherit;outline:none;background:var(--white);cursor:pointer;">
                        <option value="comments">💬 Komentar</option>
                        <option value="reactions">❤️ Reaksi</option>
                        <option value="shares">🔗 Share</option>
                    </select>
                </div>
                <div id="viralList">
                    <div style="padding:20px;">
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;margin-bottom:8px;"></div>
                        <div class="skel skel-row" style="width:100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. CATEGORY PERFORMANCE -->
        <div class="analytics-grid">
            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-ht">📁 Performa per Kategori</div>
                        <div class="card-hm">Distribusi views berdasarkan kategori</div>
                    </div>
                </div>
                <div id="categoryPerf" style="padding:8px 0;">
                    <!-- filled by JS -->
                </div>
            </div>

            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-ht">📅 Jadwal Publikasi Terbaik</div>
                        <div class="card-hm">Jam & hari dengan traffic tertinggi</div>
                    </div>
                </div>
                <div style="padding:20px 22px;">
                    <canvas id="heatmapCanvas" width="300" height="180"></canvas>
                </div>
            </div>
        </div>

        <!-- Toast -->
        <div class="toast" id="toast"></div>
    </div>
@endsection

@section('js')
    <script>
        // ═══════════════════════════════════════════════════
        // API DATA ENGINE (FULL SYNC + FULL UI FEATURES)
        // ═══════════════════════════════════════════════════
        let APP_DATA = null;
        let currentPeriod = 'week';
        let currentChartMetric = 'views';

        // 1. Render Summary
        function renderSummaryCards(d) {
            if (!d) return;

            // Helper untuk nentuin class warna berdasarkan teks (hijau jika ada '+', merah jika '0' atau '-')
            const getChgClass = (str) => {
                if (!str) return 'chg-up';

                // Ambil cuma angkanya saja dari string (misal: "Rp 233 periode ini" -> 233)
                const num = parseInt(str.replace(/[^0-9]/g, '')) || 0;

                // Kalau angkanya di atas 0, kasih Hijau. Kalau 0 atau kurang, kasih Merah.
                return num > 0 ? 'chg-up' : 'chg-dn';
            };

            document.getElementById('summaryCards').innerHTML = `
            <div class="stat-card">
                <div class="stat-ico">📰</div>
                <div class="stat-val">${(d.totalNews || 0).toLocaleString('id')}</div>
                <div class="stat-lbl">Total Berita Published</div>
                <div class="stat-chg ${getChgClass(d.newsChange)}">${d.newsChange}</div>
            </div>
            <div class="stat-card">
                <div class="stat-ico">💬</div>
                <div class="stat-val">${(d.totalComments || 0).toLocaleString('id')}</div>
                <div class="stat-lbl">Total Komentar Approved</div>
                <div class="stat-chg ${getChgClass(d.commentsChange)}">${d.commentsChange}</div>
            </div>
            <div class="stat-card">
                <div class="stat-ico">👤</div>
                <div class="stat-val">${(d.totalUsers || 0).toLocaleString('id')}</div>
                <div class="stat-lbl">Total User</div>
                <div class="stat-chg ${getChgClass(d.usersChange)}">${d.usersChange}</div>
            </div>
            <div class="stat-card">
                <div class="stat-ico">💰</div>
                <div class="stat-val">Rp ${(d.revenue).toLocaleString('id')}</div>
                <div class="stat-lbl">Total Pendapatan</div>
                <div class="stat-chg ${getChgClass(d.revenueChange)}">${d.revenueChange}</div>
            </div>
        `;
        }

        // 2. Render Chart
        function drawChart(metric) {
            if (!APP_DATA || !APP_DATA.chartData) return;
            const canvas = document.getElementById('visitChart');
            const ctx = canvas.getContext('2d');
            const data = APP_DATA.chartData;
            const values = data[metric];
            const labels = data.labels; // Tarik data label horizontal

            const w = canvas.parentElement.clientWidth;
            const h = canvas.parentElement.clientHeight;
            canvas.width = w;
            canvas.height = h;
            ctx.clearRect(0, 0, w, h);

            if (!values || values.length === 0) return;

            const allMax = Math.max(...data.views, ...data.visitors, ...data.comments);
            const maxVal = allMax * 1.2 || 10;

            // Jaga-jaga kalau datanya cuma 1 tahun (biar JS ga error Infinity)
            const stepX = values.length > 1 ? w / (values.length - 1) : w / 2;

            // BERI RUANG DI BAWAH (25px) BUAT NULIS TEKS
            const paddingBottom = 25;
            const chartH = h - paddingBottom;

            // Gambar Area (Gradient)
            const gradient = ctx.createLinearGradient(0, 0, 0, chartH);
            gradient.addColorStop(0, 'rgba(204, 0, 0, 0.2)');
            gradient.addColorStop(1, 'rgba(204, 0, 0, 0)');

            ctx.beginPath();
            ctx.fillStyle = gradient;
            values.forEach((v, i) => {
                const x = values.length > 1 ? i * stepX : w / 2;
                const y = chartH - (v / maxVal * (chartH - 20));
                if (i === 0) ctx.moveTo(x, chartH);
                ctx.lineTo(x, y);
                if (i === values.length - 1) ctx.lineTo(x, chartH);
            });
            ctx.lineTo(w, chartH);
            ctx.lineTo(0, chartH);
            ctx.fill();

            // Gambar Garis Merah Utama
            ctx.beginPath();
            ctx.strokeStyle = '#cc0000';
            ctx.lineWidth = 3;
            ctx.lineJoin = 'round';
            values.forEach((v, i) => {
                const x = values.length > 1 ? i * stepX : w / 2;
                const y = chartH - (v / maxVal * (chartH - 20));
                i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            });
            ctx.stroke();

           // === GAMBAR LABEL X-AXIS DI BAWAH GRAFIK ===
            ctx.fillStyle = "#7a7570";
            ctx.font = "11px 'JetBrains Mono', monospace";

            let skip = 1;
            // Diperlebar dikit skip-nya biar makin lega
            if (labels.length > 15) skip = Math.ceil(labels.length / 6);

            labels.forEach((label, i) => {
                let isFirst = i === 0;
                let isLast = i === labels.length - 1;
                // FIX NUMPUK: Jangan gambar 'skip' kalau dia posisinya terlalu mepet sama index terakhir
                let isTick = (i % skip === 0) && (labels.length - 1 - i > skip / 2);

                if (isFirst || isLast || isTick) {
                    let x = values.length > 1 ? i * stepX : w / 2;

                    if (isFirst) ctx.textAlign = "left";
                    else if (isLast) ctx.textAlign = "right";
                    else ctx.textAlign = "center";

                    ctx.fillText(label, x, h - 5);
                }
            });

            // Update stats di bawah (biarkan seperti sebelumnya)
            document.getElementById('chartStatsRow').innerHTML = `
                <div class="cs-item">
                    <div class="cs-val">${(data.views.reduce((a,b)=>a+b,0)).toLocaleString('id')}</div>
                    <div class="cs-lbl">Total Views</div>
                </div>
                <div class="cs-item">
                    <div class="cs-val">${(data.visitors.reduce((a,b)=>a+b,0)).toLocaleString('id')}</div>
                    <div class="cs-lbl">Unik Visitors</div>
                </div>
                <div class="cs-item">
                    <div class="cs-val">${(data.comments.reduce((a,b)=>a+b,0)).toLocaleString('id')}</div>
                    <div class="cs-lbl">Semua Komentar</div>
                </div>
            `;
        }

        // 3. Render Top News (BALIKIN MEDALI & BAR)
        function renderTopNews(list) {
            if (!list || list.length === 0) {
                document.getElementById('topNewsTable').innerHTML = `
            <div style="padding: 40px; text-align: center; color: var(--muted); font-family: 'Source Sans 3';">
                <div style="font-size: 40px; margin-bottom: 10px;">📭</div>
                <div style="font-weight: 600;">Belum ada data berita</div>
                <div style="font-size: 11px;">Tidak ada aktivitas publikasi pada periode ini.</div>
            </div>`;
                document.getElementById('topNewsSubtitle').textContent = `Top 0 berita periode ini`;
                return;
            }
            const maxViews = Math.max(...list.map(n => n.views)) || 1;
            let html =
                `<table><thead><tr><th>#</th><th>Judul Berita</th><th>Kategori</th><th>Views</th><th>Tren</th></tr></thead><tbody>`;

            list.forEach((n, i) => {
                const pct = Math.round((n.views / maxViews) * 100);
                const trendIco = n.trend === 'up' ? '▲' : '●';
                const rankLabel = i === 0 ? '🥇' : i === 1 ? '🥈' : i === 2 ? '🥉' : (i + 1);
                const rankClass = i === 0 ? 'rank-1' : i === 1 ? 'rank-2' : i === 2 ? 'rank-3' : '';

                html += `<tr>
                <td><span class="rank-num ${rankClass}">${rankLabel}</span></td>
                <td><div class="tbl-title">${n.title}</div><div class="tbl-meta">${n.author} · ${n.published}</div></td>
                <td><span class="badge b-cat">${n.category}</span></td>
                <td>
                    <div class="views-bar-wrap">
                        <div class="views-bar" style="width:${Math.max(pct, 5)}px; max-width:80px;"></div>
                        <span class="views-num">${n.views.toLocaleString('id')}</span>
                    </div>
                </td>
                <td style="color:${n.trend==='up'?'var(--success)':'var(--muted)'}; font-weight:bold;">${trendIco}</td>
            </tr>`;
            });
            document.getElementById('topNewsTable').innerHTML = html + '</tbody></table>';
            document.getElementById('topNewsSubtitle').textContent = `Top ${list.length} berita periode ini`;
        }

        // 4. Render Viral (BALIKIN PROGRESS BAR MERAH & BADGE)
        function renderViral() {
            if (!APP_DATA || !APP_DATA.viral) return;
            const filter = document.getElementById('viralFilter').value;
            const list = [...APP_DATA.viral].sort((a, b) => b[filter] - a[filter]);
            const maxVal = Math.max(...list.map(n => n[filter])) || 1;

            if (list.length === 0) {
                document.getElementById('viralList').innerHTML = `
            <div style="padding: 40px; text-align: center; color: var(--muted); font-family: 'Source Sans 3';">
                <div style="font-size: 40px; margin-bottom: 10px;">✨</div>
                <div style="font-weight: 600;">Belum ada interaksi</div>
                <div style="font-size: 11px;">Belum ada komentar atau reaksi untuk periode ini.</div>
            </div>`;
                document.getElementById('viralSubtitle').textContent = `Berdasarkan interaksi terbanyak`;
                return;
            }

            let html = '';
            list.forEach((n, i) => {
                const val = n[filter];
                const pct = Math.round((val / maxVal) * 100);
                const rankClass = i === 0 ? 'e-r1' : i === 1 ? 'e-r2' : i === 2 ? 'e-r3' : 'e-rn';
                const filterIcon = filter === 'comments' ? '💬' : filter === 'reactions' ? '❤️' : '🔗';

                html += `<div class="eng-item">
                <div class="eng-rank-badge ${rankClass}">#${i+1}</div>
                <div class="eng-content">
                    <div class="eng-title">${n.title}</div>
                    <div class="eng-metrics">
                        <div class="eng-metric">💬 <span>${n.comments}</span></div>
                        <div class="eng-metric">❤️ <span>${n.reactions}</span></div>
                        <div class="eng-metric">🔗 <span>${n.shares}</span></div>
                        <div class="eng-metric">👤 ${n.author}</div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:8px;">
                        <div style="flex:1;height:5px;background:var(--surface2);border-radius:3px;overflow:hidden;">
                            <div style="height:100%;width:${pct}%;background:linear-gradient(to right, #cc0000, #ff6b35);border-radius:3px;transition:width .8s;"></div>
                        </div>
                        <span style="font-family:'JetBrains Mono';font-size:11px;color:var(--muted);">${filterIcon} ${val}</span>
                    </div>
                </div>
            </div>`;
            });
            document.getElementById('viralList').innerHTML = html;
            document.getElementById('viralSubtitle').textContent = `Berdasarkan interaksi terbanyak`;
        }

        // 5. Render Heatmap (Publikasi Berita)
        function drawHeatmap() {
            if (!APP_DATA || !APP_DATA.heatmapData) return;
            const canvas = document.getElementById('heatmapCanvas');
            const ctx = canvas.getContext('2d');
            const d = APP_DATA.heatmapData;
            const cellW = 38,
                cellH = 22;

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            d.intensities.forEach((row, i) => {
                row.forEach((val, j) => {
                    ctx.fillStyle = `rgba(204, 0, 0, ${val})`;
                    // ctx.roundRect (hanya jika browser support) atau fillRect biasa
                    ctx.fillRect((j * cellW) + 30, (i * cellH), cellW - 5, cellH - 5);
                });
            });
            ctx.fillStyle = "#7a7570";
            ctx.font = "600 10px 'Source Sans 3'";
            d.days.forEach((day, i) => ctx.fillText(day, 0, (i * cellH) + 15));
            d.hours.forEach((hr, j) => ctx.fillText(hr, (j * cellW) + 35, 175));
        }

        // 6. Performa Kategori
        function renderCategoryPerf(list) {
            if (!list) return;
            let html = '';
            list.forEach(c => {
                html += `<div class="cat-perf-item">
                <div class="cat-emoji">📊</div>
                <div class="cat-info">
                    <div class="cat-name-lbl">${c.name}</div>
                    <div class="cat-bar-wrap">
                        <div class="cat-prog"><div class="cat-prog-fill" style="width:${c.pct}%"></div></div>
                        <span class="cat-pct">${(c.views).toLocaleString('id')} views</span>
                    </div>
                </div>
            </div>`;
            });
            document.getElementById('categoryPerf').innerHTML = html;
        }

        // --- Controller ---
        function fetchAndRenderData(p) {
            const refreshIcon = document.getElementById('refreshIcon2');
            if (refreshIcon) refreshIcon.classList.add('spin');

            fetch(`/api/admin/analitik_berita/ambilData?period=${p}`)
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        APP_DATA = res.data;
                        renderSummaryCards(APP_DATA.summary);
                        renderTopNews(APP_DATA.topNews);
                        renderViral();
                        renderCategoryPerf(APP_DATA.categoryPerformance);
                        drawChart(currentChartMetric);
                        drawHeatmap();
                        document.getElementById('lastUpdated').textContent =
                            `Terakhir diperbarui: ${new Date().toLocaleTimeString('id-ID')}`;
                    }
                    if (refreshIcon) refreshIcon.classList.remove('spin');
                })
                .catch(err => {
                    console.error(err);
                    if (refreshIcon) refreshIcon.classList.remove('spin');
                });
        }

        function setPeriod(p, btn) {
            currentPeriod = p;
            document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            fetchAndRenderData(p);
        }

        function switchChart(m, btn) {
            currentChartMetric = m;
            document.querySelectorAll('.chart-period').forEach(b => b.classList.remove('active'));

            if (btn) btn.classList.add('active');
            drawChart(m);
        }

        function loadAllData() {
            fetchAndRenderData(currentPeriod);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tbTitle = document.getElementById('tbTitle');
            const tbCrumb = document.getElementById('tbCrumb');
            if (tbTitle) tbTitle.textContent = 'Analisis Tren Berita';
            if (tbCrumb) tbCrumb.textContent = 'Admin / Analisis Tren Berita';
            loadAllData();
            // Handle responsive chart redraw
            window.addEventListener('resize', () => {
                if (APP_DATA) {
                    drawChart(currentChartMetric);
                    drawHeatmap();
                }
            });
        });
    </script>
@endsection
