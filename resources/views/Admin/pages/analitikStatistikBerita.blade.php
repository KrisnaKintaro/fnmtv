@extends('admin.master_admin')

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
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

        .stat-card:nth-child(2) { --c: #1a3a7a; }
        .stat-card:nth-child(3) { --c: #1a7a3c; }
        .stat-card:nth-child(4) { --c: #b86200; }

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

        .chg-up { color: var(--success); }
        .chg-dn { color: var(--red); }

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

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #faf9f7; }

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

        .b-pub { background: #e6f4ec; color: var(--success); }
        .b-cat { background: #fde8e8; color: var(--red); }

        .rank-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
            width: 28px;
            text-align: center;
        }

        .rank-1 { color: var(--warning); }
        .rank-2 { color: var(--muted); }
        .rank-3 { color: #8b6914; }

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

        .chart-area { padding: 20px 24px; }

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

        .cs-item { text-align: center; }

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

        .eng-item:last-child { border-bottom: none; }

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

        .e-r1 { background: #fff3cd; color: var(--warning); }
        .e-r2 { background: #e8e8e8; color: #555; }
        .e-r3 { background: #f3e8d5; color: #8b6914; }
        .e-rn { background: var(--surface2); color: var(--muted); }

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

        .cat-perf-item:last-child { border-bottom: none; }

        .cat-emoji {
            font-size: 20px;
            width: 32px;
            text-align: center;
        }

        .cat-info { flex: 1; }

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
            0%, 100% { opacity: 1; }
            50% { opacity: .4; }
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
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 550px;
        }

        /* =========================================================
           🔥 MEDIA QUERIES UNTUK LAYAR HP & TABLET 🔥
           ========================================================= */
        @media screen and (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .analytics-grid, .analytics-grid-full { grid-template-columns: 1fr; }
        }

        @media screen and (max-width: 768px) {
            .page-content { padding: 16px 12px; }
            .stats-grid { grid-template-columns: 1fr; }
            .period-bar {
                padding: 14px 16px;
                justify-content: center;
            }
            .refresh-btn {
                margin-left: 0;
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }
            .chart-stats-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .card-hd {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
@endsection

@section('konten')
    <div class="page-content">
        <div class="period-bar">
            <span class="period-lbl">Periode:</span>
            <button class="period-btn" onclick="setPeriod('today',this)">Hari ini</button>
            <button class="period-btn active" onclick="setPeriod('week',this)">7 Hari</button>
            <button class="period-btn" onclick="setPeriod('month',this)">30 Hari</button>
            <button class="period-btn" onclick="setPeriod('year',this)">1 Tahun</button>
            <button class="period-btn" onclick="setPeriod('all',this)">Semua</button>
            <span class="last-updated" id="lastUpdated">Terakhir diperbarui: —</span>
            <button class="refresh-btn" onclick="loadAllData()">
                <svg id="refreshIcon2" width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Perbarui
            </button>
        </div>

        <div class="section-title">Ringkasan Sistem</div>
        <div class="stats-grid" id="summaryCards"></div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-hd" style="flex-direction: row;">
                <div>
                    <div class="card-ht">📈 Tren Kunjungan</div>
                    <div class="card-hm">Performa traffic website</div>
                </div>
                <div style="display:flex;gap:6px;" id="chartPeriodBtns">
                    <button class="chart-period active" onclick="switchChart('views',this)">Views</button>
                    <button class="chart-period" onclick="switchChart('visitors',this)">Pengunjung</button>
                </div>
            </div>
            <div class="chart-area">
                <div class="chart-canvas-wrap" style="height:180px;">
                    <canvas id="visitChart" class="chart-canvas"></canvas>
                </div>
                <div class="chart-stats-row" id="chartStatsRow"></div>
            </div>
        </div>

        <div class="analytics-grid-full">
            <div class="card">
                <div class="card-hd" style="flex-direction: row;">
                    <div>
                        <div class="card-ht">👑 Top Berita Dilihat</div>
                        <div class="card-hm" id="topNewsSubtitle">Memuat data...</div>
                    </div>
                    <span class="badge b-pub">Live</span>
                </div>
                <div id="topNewsTable" class="table-responsive">
                    <div style="padding:20px;">
                        <div class="skel skel-row"></div><div class="skel skel-row"></div><div class="skel skel-row"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-hd" style="flex-direction: row;">
                    <div>
                        <div class="card-ht">🔥 Viral Tracker</div>
                        <div class="card-hm" id="viralSubtitle">Memuat data...</div>
                    </div>
                    <select id="viralFilter" onchange="renderViral()" style="border:1px solid var(--border);border-radius:6px;padding:5px;font-size:12px;outline:none;cursor:pointer;">
                        <option value="comments">💬 Komentar</option>
                        <option value="reactions">❤️ Reaksi</option>
                        <option value="shares">🔗 Share</option>
                    </select>
                </div>
                <div id="viralList">
                    <div style="padding:20px;"><div class="skel skel-row"></div><div class="skel skel-row"></div></div>
                </div>
            </div>
        </div>

        <div class="analytics-grid">
            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-ht">📁 Performa Kategori</div>
                        <div class="card-hm">Distribusi views berdasarkan kategori</div>
                    </div>
                </div>
                <div id="categoryPerf" style="padding:8px 0;"></div>
            </div>

            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-ht">📅 Jadwal Publikasi Terbaik</div>
                        <div class="card-hm">Jam & hari dengan traffic tertinggi</div>
                    </div>
                </div>
                <div style="padding:20px 22px; width: 100%; box-sizing: border-box;" id="heatmapContainer">
                    <canvas id="heatmapCanvas"></canvas>
                </div>
            </div>
        </div>

        <div class="toast" id="toast"></div>
    </div>
@endsection

@section('js')
    <script>
        let APP_DATA = null;
        let currentPeriod = 'week';
        let currentChartMetric = 'views';

        // MENGATASI ISU PLACEHOLDER SEARCH BAR DI HP & PC BEDA TEKS
        document.addEventListener('DOMContentLoaded', () => {
            const placeholderText = 'Cari data analitik...';

            // Ganti teks placeholder versi PC dan versi HP secara sinkron
            const searchInputs = document.querySelectorAll('#searchInput, .mobile-search-input');
            searchInputs.forEach(input => {
                input.placeholder = placeholderText;
            });

            // Setup Text Halaman Dashboard
            const tbTitle = document.getElementById('tbTitle');
            const tbCrumb = document.getElementById('tbCrumb');
            if (tbTitle) tbTitle.textContent = 'Analisis Tren Berita';
            if (tbCrumb) tbCrumb.textContent = 'Admin / Analisis Tren Berita';

            loadAllData();

            // Handle redraw untuk responsive Canvas saat layar dibolak-balik
            window.addEventListener('resize', () => {
                if (APP_DATA) {
                    drawChart(currentChartMetric);
                    drawHeatmap();
                }
            });
        });

        // 1. Render Summary
        function renderSummaryCards(d) {
            if (!d) return;
            const getChgClass = (str) => {
                if (!str) return 'chg-up';
                const num = parseInt(str.replace(/[^0-9]/g, '')) || 0;
                return num > 0 ? 'chg-up' : 'chg-dn';
            };

            document.getElementById('summaryCards').innerHTML = `
            <div class="stat-card">
                <div class="stat-ico">📰</div>
                <div class="stat-val">${(d.totalNews || 0).toLocaleString('id')}</div>
                <div class="stat-lbl">Total Berita</div>
                <div class="stat-chg ${getChgClass(d.newsChange)}">${d.newsChange}</div>
            </div>
            <div class="stat-card">
                <div class="stat-ico">💬</div>
                <div class="stat-val">${(d.totalComments || 0).toLocaleString('id')}</div>
                <div class="stat-lbl">Komentar</div>
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
                <div class="stat-lbl">Pendapatan</div>
                <div class="stat-chg ${getChgClass(d.revenueChange)}">${d.revenueChange}</div>
            </div>`;
        }

        // 2. Render Chart View (Tetap dinamis dan fluid)
        function drawChart(metric) {
            if (!APP_DATA || !APP_DATA.chartData) return;
            const canvas = document.getElementById('visitChart');
            const ctx = canvas.getContext('2d');
            const data = APP_DATA.chartData;
            const values = data[metric];
            const labels = data.labels;

            const W = canvas.parentElement.clientWidth;
            const H = canvas.parentElement.clientHeight || 180;
            canvas.width = W;
            canvas.height = H;

            ctx.clearRect(0, 0, W, H);
            if (!values || values.length === 0) return;

            const padL = 48, padR = 24, padT = 16, padB = 28;
            const chartW = W - padL - padR;
            const chartH = H - padT - padB;

            const maxVal = Math.max(...values) * 1.15 || 10;
            const step = values.length > 1 ? chartW / (values.length - 1) : chartW / 2;

            // Grid y-axis
            ctx.strokeStyle = '#e0ddd6';
            ctx.lineWidth = 1;
            for (let i = 0; i <= 4; i++) {
                const y = padT + chartH - (i / 4) * chartH;
                ctx.beginPath(); ctx.moveTo(padL, y); ctx.lineTo(W - padR, y); ctx.stroke();
                ctx.fillStyle = '#7a7570'; ctx.font = '10px JetBrains Mono, monospace'; ctx.textAlign = 'right';
                const val = Math.round((maxVal / 4) * i);
                const textVal = val >= 1000 ? (val / 1000).toFixed(1).replace('.0','') + 'K' : val;
                ctx.fillText(textVal, padL - 8, y + 3);
            }

            const gradient = ctx.createLinearGradient(0, padT, 0, padT + chartH);
            gradient.addColorStop(0, 'rgba(204,0,0,0.18)');
            gradient.addColorStop(1, 'rgba(204,0,0,0.01)');

            ctx.beginPath();
            values.forEach((v, i) => {
                const x = values.length > 1 ? padL + (i * step) : padL + (chartW / 2);
                const y = padT + chartH - (v / maxVal) * chartH;
                if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
            });
            ctx.lineTo(values.length > 1 ? padL + chartW : padL + (chartW / 2), padT + chartH);
            ctx.lineTo(padL, padT + chartH);
            ctx.closePath();
            ctx.fillStyle = gradient; ctx.fill();

            ctx.beginPath();
            ctx.strokeStyle = '#cc0000'; ctx.lineWidth = 2.5; ctx.lineJoin = 'round';
            values.forEach((v, i) => {
                const x = values.length > 1 ? padL + (i * step) : padL + (chartW / 2);
                const y = padT + chartH - (v / maxVal) * chartH;
                if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
            });
            ctx.stroke();

            let skip = 1;
            if (labels.length > 15) skip = Math.ceil(labels.length / 6);

            values.forEach((v, i) => {
                const x = values.length > 1 ? padL + (i * step) : padL + (chartW / 2);
                const y = padT + chartH - (v / maxVal) * chartH;

                ctx.beginPath(); ctx.arc(x, y, 4, 0, Math.PI * 2);
                ctx.fillStyle = '#fff'; ctx.fill();
                ctx.strokeStyle = '#cc0000'; ctx.lineWidth = 2; ctx.stroke();

                let isFirst = i === 0, isLast = i === labels.length - 1;
                let isTick = (i % skip === 0) && (labels.length - 1 - i > skip / 2);

                if (isFirst || isLast || isTick) {
                    ctx.fillStyle = '#7a7570'; ctx.font = "11px 'JetBrains Mono', monospace";
                    if (isFirst) ctx.textAlign = "left";
                    else if (isLast) ctx.textAlign = "right";
                    else ctx.textAlign = "center";
                    ctx.fillText(labels[i], x, padT + chartH + 18);
                }
            });

            const total = values.reduce((a, b) => a + b, 0);
            const avg = Math.round(total / (values.length || 1));
            const peak = Math.max(...values, 0);
            let labelName = metric === 'visitors' ? 'Pengunjung' : metric === 'comments' ? 'Komentar' : 'Views';

            document.getElementById('chartStatsRow').innerHTML = `
                <div class="cs-item"><div class="cs-val">${total.toLocaleString('id')}</div><div class="cs-lbl">Total ${labelName}</div></div>
                <div class="cs-item"><div class="cs-val">${avg.toLocaleString('id')}</div><div class="cs-lbl">Rata-rata/hari</div></div>
                <div class="cs-item"><div class="cs-val">${peak.toLocaleString('id')}</div><div class="cs-lbl">Peak ${labelName}</div></div>
            `;
        }

        // 3. Render Top News
        function renderTopNews(list) {
            if (!list || list.length === 0) {
                document.getElementById('topNewsTable').innerHTML = `<div style="padding:40px;text-align:center;color:var(--muted);"><div style="font-size:40px;">📭</div><div>Belum ada data</div></div>`;
                return;
            }
            const maxViews = Math.max(...list.map(n => n.views)) || 1;
            let html = `<table><thead><tr><th>#</th><th>Judul</th><th>Kategori</th><th>Views</th><th>Tren</th></tr></thead><tbody>`;

            list.forEach((n, i) => {
                const pct = Math.round((n.views / maxViews) * 100);
                const trendIco = n.trend === 'up' ? '▲' : '●';
                const rankClass = i === 0 ? 'rank-1' : i === 1 ? 'rank-2' : i === 2 ? 'rank-3' : '';
                const rankLabel = i === 0 ? '🥇' : i === 1 ? '🥈' : i === 2 ? '🥉' : (i + 1);

                html += `<tr>
                <td><span class="rank-num ${rankClass}">${rankLabel}</span></td>
                <td><div class="tbl-title">${n.title}</div><div class="tbl-meta">${n.author}</div></td>
                <td><span class="badge b-cat">${n.category}</span></td>
                <td><div class="views-bar-wrap"><div class="views-bar" style="width:${Math.max(pct, 5)}px;max-width:80px;"></div><span class="views-num">${n.views.toLocaleString('id')}</span></div></td>
                <td style="color:${n.trend==='up'?'var(--success)':'var(--muted)'};font-weight:bold;">${trendIco}</td></tr>`;
            });
            document.getElementById('topNewsTable').innerHTML = html + '</tbody></table>';
            document.getElementById('topNewsSubtitle').textContent = `Top ${list.length} berita periode ini`;
        }

        // 4. Render Viral
        function renderViral() {
            if (!APP_DATA || !APP_DATA.viral) return;
            const filter = document.getElementById('viralFilter').value;
            const list = [...APP_DATA.viral].sort((a, b) => b[filter] - a[filter]);
            const maxVal = Math.max(...list.map(n => n[filter])) || 1;

            if (list.length === 0) {
                document.getElementById('viralList').innerHTML = `<div style="padding:40px;text-align:center;color:var(--muted);"><div style="font-size:40px;">✨</div><div>Belum ada interaksi</div></div>`;
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
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:8px;">
                        <div style="flex:1;height:5px;background:var(--surface2);border-radius:3px;"><div style="height:100%;width:${pct}%;background:linear-gradient(to right,#cc0000,#ff6b35);border-radius:3px;"></div></div>
                        <span style="font-size:11px;color:var(--muted);">${filterIcon} ${val}</span>
                    </div>
                </div></div>`;
            });
            document.getElementById('viralList').innerHTML = html;
        }

        // 5. Render Heatmap (Telah dioptimalkan menjadi Canvas Responsif / Fluid)
        function drawHeatmap() {
            if (!APP_DATA || !APP_DATA.heatmapData) return;
            const canvas = document.getElementById('heatmapCanvas');
            const ctx = canvas.getContext('2d');
            const d = APP_DATA.heatmapData;

            // Ukur lebar asli dari parent container (bukan hardcoded 300px lagi)
            const W = canvas.parentElement.clientWidth;
            const H = 220;
            canvas.width = W;
            canvas.height = H;

            ctx.clearRect(0, 0, W, H);

            // Setup padding
            const padL = 35, padR = 10, padT = 10, padB = 25;
            const chartW = W - padL - padR;
            const chartH = H - padT - padB;

            const cols = d.hours.length || 24;
            const rows = d.days.length || 7;
            const cellW = chartW / cols;
            const cellH = chartH / rows;

            // Gambar kotak-kotak intensitas (Heatmap Cells)
            d.intensities.forEach((row, i) => {
                row.forEach((val, j) => {
                    ctx.fillStyle = `rgba(204, 0, 0, ${val})`;
                    ctx.fillRect(padL + (j * cellW), padT + (i * cellH), cellW - 1, cellH - 1);
                });
            });

            // Tulis label sumbu Y (Nama Hari)
            ctx.fillStyle = "#7a7570";
            ctx.font = "600 10px 'Source Sans 3'";
            ctx.textAlign = "left";
            ctx.textBaseline = "middle";
            d.days.forEach((day, i) => {
                // Di layar sempit, singkat hari jadi 3 huruf (cth: "Sen", "Sel")
                let textDay = W < 400 ? day.substring(0,3) : day;
                ctx.fillText(textDay, 0, padT + (i * cellH) + (cellH / 2));
            });

            // Tulis label sumbu X (Jam)
            ctx.textAlign = "center";
            ctx.textBaseline = "top";

            // Logic cerdas: kalau layar sempit, teks sumbu X diloncat (skip) biar gak tabrakan/tumpuk-tumpukan
            let skip = W < 500 ? 3 : (W < 768 ? 2 : 1);
            d.hours.forEach((hr, j) => {
                if (j % skip === 0) {
                    ctx.fillText(hr, padL + (j * cellW) + (cellW / 2), H - padB + 6);
                }
            });
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
                        <span class="cat-pct">${(c.views).toLocaleString('id')} v</span>
                    </div>
                </div></div>`;
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
                        document.getElementById('lastUpdated').textContent = `Diperbarui: ${new Date().toLocaleTimeString('id-ID')}`;
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
    </script>
@endsection
