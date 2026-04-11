@extends('Admin.master_admin')

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
body{background:var(--bg);color:var(--text);}
.page-content{padding:20px 24px;}
.section-title{font-family:'Merriweather',serif;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:var(--muted);margin-bottom:14px;margin-top:4px;}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;}
.stat-card{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:20px 22px;position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s;}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 24px rgba(0,0,0,.08);}
.stat-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--c,var(--red));}
.stat-card:nth-child(2){--c:#1a3a7a;}
.stat-card:nth-child(3){--c:#1a7a3c;}
.stat-card:nth-child(4){--c:#b86200;}
.stat-ico{font-size:26px;margin-bottom:10px;}
.stat-val{font-family:'Merriweather',serif;font-size:26px;font-weight:900;line-height:1;margin-bottom:5px;}
.stat-lbl{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:1.5px;}
.stat-chg{font-size:11px;margin-top:6px;display:flex;align-items:center;gap:4px;}
.chg-up{color:var(--success);}
.chg-dn{color:var(--red);}
.analytics-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;margin-bottom:20px;}
.analytics-grid-full{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;}
.card{background:var(--white);border:1px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:0;}
.card-hd{padding:16px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.card-ht{font-family:'Merriweather',serif;font-size:14px;font-weight:700;}
.card-hm{font-size:12px;color:var(--muted);}
table{width:100%;border-collapse:collapse;}
th{text-align:left;padding:10px 18px;font-size:11px;color:var(--muted);letter-spacing:1.5px;text-transform:uppercase;border-bottom:1px solid var(--border);font-weight:600;background:#fcfbf9;}
td{padding:12px 18px;font-size:13px;border-bottom:1px solid var(--border);vertical-align:middle;}
tr:last-child td{border-bottom:none;}
tr:hover td{background:#faf9f7;}
.tbl-title{font-weight:600;font-size:13px;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.tbl-meta{font-size:11px;color:var(--muted);margin-top:2px;}
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:12px;font-size:11px;font-weight:600;}
.b-pub{background:#e6f4ec;color:var(--success);}
.b-cat{background:#fde8e8;color:var(--red);}
.rank-num{font-family:'JetBrains Mono',monospace;font-size:13px;font-weight:700;color:var(--muted);width:28px;text-align:center;}
.rank-1{color:var(--warning);}
.rank-2{color:var(--muted);}
.rank-3{color:#8b6914;}
.views-bar-wrap{display:flex;align-items:center;gap:10px;}
.views-bar{height:6px;border-radius:3px;background:var(--red);opacity:.7;transition:width .6s ease;}
.views-num{font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--muted);white-space:nowrap;}
.chart-area{padding:20px 24px;}
.chart-period{padding:5px 12px;border-radius:5px;font-size:12px;font-weight:600;cursor:pointer;border:1px solid var(--border);background:var(--white);color:var(--muted);transition:.15s;font-family:inherit;}
.chart-period.active{background:var(--red);color:#fff;border-color:var(--red);}
.chart-period:hover:not(.active){border-color:var(--red);color:var(--red);}
.chart-canvas-wrap{position:relative;height:160px;margin-bottom:12px;}
.chart-canvas{width:100%;height:100%;}
.chart-stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:14px;padding-top:14px;border-top:1px solid var(--border);}
.cs-item{text-align:center;}
.cs-val{font-family:'Merriweather',serif;font-size:16px;font-weight:900;}
.cs-lbl{font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-top:2px;}
.eng-item{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;gap:12px;align-items:flex-start;}
.eng-item:last-child{border-bottom:none;}
.eng-rank-badge{width:28px;height:28px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:700;flex-shrink:0;}
.e-r1{background:#fff3cd;color:var(--warning);}
.e-r2{background:#e8e8e8;color:#555;}
.e-r3{background:#f3e8d5;color:#8b6914;}
.e-rn{background:var(--surface2);color:var(--muted);}
.eng-content{flex:1;min-width:0;}
.eng-title{font-weight:600;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:6px;}
.eng-metrics{display:flex;gap:12px;flex-wrap:wrap;}
.eng-metric{display:flex;align-items:center;gap:4px;font-size:11px;color:var(--muted);}
.eng-metric span{font-family:'JetBrains Mono',monospace;font-weight:600;color:var(--text);}
.cat-perf-item{padding:12px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:14px;}
.cat-perf-item:last-child{border-bottom:none;}
.cat-emoji{font-size:20px;width:32px;text-align:center;}
.cat-info{flex:1;}
.cat-name-lbl{font-size:13px;font-weight:600;margin-bottom:4px;}
.cat-bar-wrap{display:flex;align-items:center;gap:8px;}
.cat-prog{flex:1;height:5px;background:var(--surface2);border-radius:3px;overflow:hidden;}
.cat-prog-fill{height:100%;border-radius:3px;background:var(--red);transition:width .8s ease;}
.cat-pct{font-family:'JetBrains Mono',monospace;font-size:11px;color:var(--muted);white-space:nowrap;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.4;}}
.skel{background:var(--surface2);border-radius:4px;animation:pulse 1.5s ease-in-out infinite;}
.skel-row{height:44px;margin-bottom:2px;}
.spin{animation:spin 1s linear infinite;}
@keyframes spin{from{transform:rotate(0deg);}to{transform:rotate(360deg);}}
.period-bar{display:flex;align-items:center;gap:8px;margin-bottom:20px;flex-wrap:wrap;padding:20px 24px;border-bottom:1px solid var(--border);background:var(--white);}
.period-lbl{font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-right:4px;}
.period-btn{padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);background:var(--white);color:var(--muted);transition:.15s;font-family:inherit;}
.period-btn.active{background:var(--text);color:#fff;border-color:var(--text);}
.period-btn:hover:not(.active){border-color:var(--text);color:var(--text);}
.refresh-btn{margin-left:auto;display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);background:var(--white);color:var(--muted);transition:.15s;font-family:inherit;}
.refresh-btn:hover{border-color:var(--red);color:var(--red);}
.last-updated{font-size:11px;color:var(--muted);}
.toast{position:fixed;bottom:24px;right:24px;background:var(--text);color:#fff;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:600;z-index:999;opacity:0;transform:translateY(10px);transition:all .3s;pointer-events:none;}
.toast.show{opacity:1;transform:translateY(0);}
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
        <span class="last-updated" id="lastUpdated">Terakhir diperbarui: —</span>
        <button class="refresh-btn" onclick="loadAllData()">
            <svg id="refreshIcon2" width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div id="topNewsTable">
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
        // API DATA ENGINE
        // ═══════════════════════════════════════════════════

        let APP_DATA = {
            summary: {},
            topNews: [],
            viral: [],
            chart: {},
            categories: [],
            heatmap: {}
        };

        const MOCK_DATA = {
            summary: {
                totalNews: 2847,
                totalComments: 14280,
                totalUsers: 8934,
                revenue: 12400000,
                newsChange: '+14 artikel hari ini',
                commentsChange: '+127 komentar hari ini',
                usersChange: '+43 user minggu ini',
                revenueChange: '+Rp 1.2M bulan ini'
            },
            topNews: [{
                    id: 1,
                    title: 'Pemerintah Umumkan Kebijakan Subsidi Kendaraan Listrik 2026',
                    category: 'Politik',
                    views: 48290,
                    author: 'Budi S.',
                    published: '09 Apr 2026',
                    trend: 'up'
                },
                {
                    id: 2,
                    title: 'Timnas Garuda Menang 3-0 Lawan Vietnam di Piala AFF',
                    category: 'Olahraga',
                    views: 42100,
                    author: 'Rina A.',
                    published: '10 Apr 2026',
                    trend: 'up'
                },
                {
                    id: 3,
                    title: 'IHSG Melonjak 2.8% Dipicu Sentimen Global Positif',
                    category: 'Ekonomi',
                    views: 38750,
                    author: 'Dewi P.',
                    published: '11 Apr 2026',
                    trend: 'stable'
                },
                {
                    id: 4,
                    title: 'Gempa Bumi M6.2 Guncang Sulawesi Tengah, Tak Ada Korban',
                    category: 'Nasional',
                    views: 34200,
                    author: 'Fajar M.',
                    published: '10 Apr 2026',
                    trend: 'up'
                },
                {
                    id: 5,
                    title: 'Startup AI Indonesia Raih Pendanaan Seri B USD 50 Juta',
                    category: 'Teknologi',
                    views: 29800,
                    author: 'Reza K.',
                    published: '08 Apr 2026',
                    trend: 'up'
                },
                {
                    id: 6,
                    title: 'Cuaca Ekstrem Diprediksi Melanda Jawa-Bali Pekan Ini',
                    category: 'Nasional',
                    views: 27400,
                    author: 'Sari N.',
                    published: '11 Apr 2026',
                    trend: 'stable'
                },
                {
                    id: 7,
                    title: 'Bank Indonesia Pertahankan Suku Bunga di Level 6.25%',
                    category: 'Ekonomi',
                    views: 23100,
                    author: 'Budi S.',
                    published: '09 Apr 2026',
                    trend: 'down'
                },
                {
                    id: 8,
                    title: 'Film "Lautan Merah" Pecahkan Rekor Penonton Nasional',
                    category: 'Hiburan',
                    views: 19500,
                    author: 'Lina W.',
                    published: '07 Apr 2026',
                    trend: 'stable'
                },
            ],
            viral: [{
                    id: 1,
                    title: 'Timnas Garuda Menang 3-0 Lawan Vietnam di Piala AFF',
                    category: 'Olahraga',
                    comments: 1840,
                    reactions: 9200,
                    shares: 3100,
                    author: 'Rina A.'
                },
                {
                    id: 2,
                    title: 'Pemerintah Umumkan Kebijakan Subsidi Kendaraan Listrik',
                    category: 'Politik',
                    comments: 1540,
                    reactions: 7400,
                    shares: 2800,
                    author: 'Budi S.'
                },
                {
                    id: 3,
                    title: 'Gempa Bumi M6.2 Guncang Sulawesi Tengah',
                    category: 'Nasional',
                    comments: 1210,
                    reactions: 6100,
                    shares: 4200,
                    author: 'Fajar M.'
                },
                {
                    id: 4,
                    title: 'Startup AI Indonesia Raih Pendanaan Seri B USD 50 Juta',
                    category: 'Teknologi',
                    comments: 980,
                    reactions: 5500,
                    shares: 1900,
                    author: 'Reza K.'
                },
                {
                    id: 5,
                    title: 'Film "Lautan Merah" Pecahkan Rekor Penonton Nasional',
                    category: 'Hiburan',
                    comments: 870,
                    reactions: 4800,
                    shares: 2200,
                    author: 'Lina W.'
                },
            ],
            chart: {
                week: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    views: [12400, 14800, 13200, 16900, 15400, 19200, 18100],
                    visitors: [4200, 5100, 4800, 6200, 5700, 7100, 6800],
                    comments: [380, 420, 310, 580, 490, 710, 650],
                },
                month: {
                    labels: ['1', '5', '10', '15', '20', '25', '30'],
                    views: [9200, 11000, 14800, 12400, 16900, 15200, 18100],
                    visitors: [3400, 3900, 5100, 4600, 6200, 5800, 6800],
                    comments: [280, 320, 420, 390, 580, 520, 650],
                },
                today: {
                    labels: ['06', '08', '10', '12', '14', '16', '18'],
                    views: [1200, 2400, 4100, 5800, 4200, 3900, 2800],
                    visitors: [450, 880, 1520, 2100, 1600, 1400, 1050],
                    comments: [40, 80, 140, 210, 170, 150, 110],
                },
                year: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
                    views: [420000, 395000, 468000, 502000, 489000, 531000, 0],
                    visitors: [145000, 138000, 162000, 174000, 168000, 185000, 0],
                    comments: [12400, 11800, 14200, 15800, 14900, 16700, 0],
                }
            },
            categories: [{
                    name: 'Politik',
                    emoji: '🏛',
                    views: 142000,
                    pct: 100
                },
                {
                    name: 'Olahraga',
                    emoji: '⚽',
                    views: 128500,
                    pct: 90
                },
                {
                    name: 'Ekonomi',
                    emoji: '💹',
                    views: 98400,
                    pct: 69
                },
                {
                    name: 'Teknologi',
                    emoji: '💻',
                    views: 87200,
                    pct: 61
                },
                {
                    name: 'Nasional',
                    emoji: '🇮🇩',
                    views: 76800,
                    pct: 54
                },
                {
                    name: 'Hiburan',
                    emoji: '🎬',
                    views: 58300,
                    pct: 41
                },
                {
                    name: 'Kesehatan',
                    emoji: '🏥',
                    views: 42100,
                    pct: 30
                },
                {
                    name: 'Olahraga Luar',
                    emoji: '🎾',
                    views: 21400,
                    pct: 15
                },
            ]
        };

        let currentPeriod = 'week';
        let currentChartMetric = 'views';

        // ═══════════════════════════════════════════════════
        // RENDER FUNCTIONS
        // ═══════════════════════════════════════════════════

        function renderSummaryCards(data) {
            const d = data || MOCK_DATA.summary;
            document.getElementById('summaryCards').innerHTML = `
    <div class="stat-card">
      <div class="stat-ico">📰</div>
      <div class="stat-val">${d.totalNews.toLocaleString('id')}</div>
      <div class="stat-lbl">Total Berita Published</div>
      <div class="stat-chg chg-up">▲ ${d.newsChange}</div>
    </div>
    <div class="stat-card">
      <div class="stat-ico">💬</div>
      <div class="stat-val">${d.totalComments.toLocaleString('id')}</div>
      <div class="stat-lbl">Total Komentar</div>
      <div class="stat-chg chg-up">▲ ${d.commentsChange}</div>
    </div>
    <div class="stat-card">
      <div class="stat-ico">👤</div>
      <div class="stat-val">${d.totalUsers.toLocaleString('id')}</div>
      <div class="stat-lbl">Total User Terdaftar</div>
      <div class="stat-chg chg-up">▲ ${d.usersChange}</div>
    </div>
    <div class="stat-card">
      <div class="stat-ico">💰</div>
      <div class="stat-val">Rp ${(d.revenue/1000000).toFixed(1)}M</div>
      <div class="stat-lbl">Pendapatan Bulan Ini</div>
      <div class="stat-chg chg-up">▲ ${d.revenueChange}</div>
    </div>
  `;
        }

        function renderTopNews(data) {
            const list = data || MOCK_DATA.topNews;
            const maxViews = Math.max(...list.map(n => n.views));
            let html = `<table>
    <thead><tr>
      <th style="width:40px;">#</th>
      <th>Judul Berita</th>
      <th>Kategori</th>
      <th>Views</th>
      <th>Tren</th>
    </tr></thead>
    <tbody>`;
            list.forEach((n, i) => {
                const pct = Math.round((n.views / maxViews) * 100);
                const trendIcon = n.trend === 'up' ? '▲' : n.trend === 'down' ? '▼' : '→';
                const trendColor = n.trend === 'up' ? 'var(--success)' : n.trend === 'down' ? 'var(--red)' :
                    'var(--muted)';
                const rankClass = i === 0 ? 'rank-1' : i === 1 ? 'rank-2' : i === 2 ? 'rank-3' : '';
                html += `<tr>
      <td><span class="rank-num ${rankClass}">${i === 0 ? '🥇' : i === 1 ? '🥈' : i === 2 ? '🥉' : (i+1)}</span></td>
      <td>
        <div class="tbl-title">${n.title}</div>
        <div class="tbl-meta">${n.author} · ${n.published}</div>
      </td>
      <td><span class="badge b-cat">${n.category}</span></td>
      <td>
        <div class="views-bar-wrap">
          <div class="views-bar" style="width:${Math.max(pct,8)}px;max-width:80px;"></div>
          <span class="views-num">${n.views.toLocaleString('id')}</span>
        </div>
      </td>
      <td><span style="color:${trendColor};font-weight:700;font-size:13px;">${trendIcon}</span></td>
    </tr>`;
            });
            html += '</tbody></table>';
            document.getElementById('topNewsTable').innerHTML = html;
            document.getElementById('topNewsSubtitle').textContent =
                `Top ${list.length} berita · ${currentPeriod === 'week' ? '7 hari' : currentPeriod === 'month' ? '30 hari' : currentPeriod === 'today' ? 'hari ini' : '1 tahun'} terakhir`;
        }

        function renderViral(data) {
            const list = data || MOCK_DATA.viral;
            const filter = document.getElementById('viralFilter').value;
            const sorted = [...list].sort((a, b) => b[filter] - a[filter]);
            const maxVal = Math.max(...sorted.map(n => n[filter]));
            let html = '';
            sorted.forEach((n, i) => {
                const val = n[filter];
                const pct = Math.round((val / maxVal) * 100);
                const rankClass = i === 0 ? 'e-r1' : i === 1 ? 'e-r2' : i === 2 ? 'e-r3' : 'e-rn';
                const filterLabel = filter === 'comments' ? '💬' : filter === 'reactions' ? '❤️' : '🔗';
                html += `<div class="eng-item">
      <div class="eng-rank-badge ${rankClass}">#${i+1}</div>
      <div class="eng-content">
        <div class="eng-title">${n.title}</div>
        <div class="eng-metrics">
          <div class="eng-metric">💬 <span>${n.comments.toLocaleString('id')}</span></div>
          <div class="eng-metric">❤️ <span>${n.reactions.toLocaleString('id')}</span></div>
          <div class="eng-metric">🔗 <span>${n.shares.toLocaleString('id')}</span></div>
          <div class="eng-metric"><span class="badge b-cat" style="font-size:10px;padding:2px 6px;">${n.category}</span></div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;margin-top:6px;">
          <div style="flex:1;height:5px;background:var(--surface2);border-radius:3px;overflow:hidden;">
            <div style="height:100%;width:${pct}%;background:linear-gradient(to right,var(--red),#ff6b35);border-radius:3px;transition:width .8s;"></div>
          </div>
          <span style="font-family:'JetBrains Mono';font-size:11px;color:var(--muted);">${filterLabel} ${val.toLocaleString('id')}</span>
        </div>
      </div>
    </div>`;
            });
            document.getElementById('viralList').innerHTML = html;
            document.getElementById('viralSubtitle').textContent =
                `Diurutkan berdasarkan ${filter === 'comments' ? 'komentar' : filter === 'reactions' ? 'reaksi' : 'share'} terbanyak`;
        }

        function renderCategoryPerf(data) {
            const list = data || MOCK_DATA.categories;
            let html = '';
            list.forEach(c => {
                html += `<div class="cat-perf-item">
      <div class="cat-emoji">${c.emoji}</div>
      <div class="cat-info">
        <div class="cat-name-lbl">${c.name}</div>
        <div class="cat-bar-wrap">
          <div class="cat-prog"><div class="cat-prog-fill" style="width:${c.pct}%;"></div></div>
          <span class="cat-pct">${c.views.toLocaleString('id')} views</span>
        </div>
      </div>
    </div>`;
            });
            document.getElementById('categoryPerf').innerHTML = html;
        }

        // ═══════════════════════════════════════════════════
        // CHART ENGINE (Canvas)
        // ═══════════════════════════════════════════════════

        function drawChart(metric, period) {
            const canvas = document.getElementById('visitChart');
            const ctx = canvas.getContext('2d');
            const data = MOCK_DATA.chart[period] || MOCK_DATA.chart.week;
            const values = data[metric];
            const labels = data.labels;
            const W = canvas.offsetWidth || 500;
            const H = canvas.offsetHeight || 160;
            canvas.width = W;
            canvas.height = H;

            const padL = 48,
                padR = 16,
                padT = 16,
                padB = 28;
            const chartW = W - padL - padR;
            const chartH = H - padT - padB;

            ctx.clearRect(0, 0, W, H);

            const maxVal = Math.max(...values) * 1.15 || 1;
            const step = chartW / (values.length - 1);

            // Grid lines
            ctx.strokeStyle = '#e0ddd6';
            ctx.lineWidth = 1;
            for (let i = 0; i <= 4; i++) {
                const y = padT + chartH - (i / 4) * chartH;
                ctx.beginPath();
                ctx.moveTo(padL, y);
                ctx.lineTo(W - padR, y);
                ctx.stroke();
                ctx.fillStyle = '#7a7570';
                ctx.font = '10px JetBrains Mono, monospace';
                ctx.textAlign = 'right';
                const val = Math.round((maxVal / 4) * i);
                ctx.fillText(val >= 1000 ? (val / 1000).toFixed(0) + 'K' : val, padL - 6, y + 3);
            }

            // Area fill
            const gradient = ctx.createLinearGradient(0, padT, 0, padT + chartH);
            gradient.addColorStop(0, 'rgba(204,0,0,0.18)');
            gradient.addColorStop(1, 'rgba(204,0,0,0.01)');
            ctx.beginPath();
            values.forEach((v, i) => {
                const x = padL + i * step;
                const y = padT + chartH - (v / maxVal) * chartH;
                i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            });
            ctx.lineTo(padL + (values.length - 1) * step, padT + chartH);
            ctx.lineTo(padL, padT + chartH);
            ctx.closePath();
            ctx.fillStyle = gradient;
            ctx.fill();

            // Line
            ctx.beginPath();
            ctx.strokeStyle = '#cc0000';
            ctx.lineWidth = 2.5;
            ctx.lineJoin = 'round';
            values.forEach((v, i) => {
                const x = padL + i * step;
                const y = padT + chartH - (v / maxVal) * chartH;
                i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            });
            ctx.stroke();

            // Dots + Labels
            values.forEach((v, i) => {
                const x = padL + i * step;
                const y = padT + chartH - (v / maxVal) * chartH;
                ctx.beginPath();
                ctx.arc(x, y, 4, 0, Math.PI * 2);
                ctx.fillStyle = '#fff';
                ctx.fill();
                ctx.strokeStyle = '#cc0000';
                ctx.lineWidth = 2;
                ctx.stroke();
                ctx.fillStyle = '#7a7570';
                ctx.font = '10px Source Sans 3, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(labels[i], x, padT + chartH + 16);
            });

            // Chart stats summary
            const total = values.reduce((a, b) => a + b, 0);
            const avg = Math.round(total / values.length);
            const peak = Math.max(...values);
            const metricLabel = metric === 'views' ? 'Views' : metric === 'visitors' ? 'Pengunjung' : 'Komentar';
            document.getElementById('chartStatsRow').innerHTML = `
    <div class="cs-item">
      <div class="cs-val">${total.toLocaleString('id')}</div>
      <div class="cs-lbl">Total ${metricLabel}</div>
    </div>
    <div class="cs-item">
      <div class="cs-val">${avg.toLocaleString('id')}</div>
      <div class="cs-lbl">Rata-rata/hari</div>
    </div>
    <div class="cs-item">
      <div class="cs-val">${peak.toLocaleString('id')}</div>
      <div class="cs-lbl">Peak ${metricLabel}</div>
    </div>
  `;
        }

        function drawHeatmap() {
            const canvas = document.getElementById('heatmapCanvas');
            const ctx = canvas.getContext('2d');
            const W = canvas.width,
                H = canvas.height;
            ctx.clearRect(0, 0, W, H);

            // Use API data if available, otherwise fall back to defaults
            const heatmapData = APP_DATA.heatmapData || {};
            const days = heatmapData.days || ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            const hours = heatmapData.hours || ['06', '09', '12', '15', '18', '21'];
            const intensities = heatmapData.intensities || [
                [0.2, 0.4, 0.7, 0.5, 0.3, 0.2],
                [0.3, 0.5, 0.8, 0.6, 0.4, 0.3],
                [0.3, 0.6, 0.9, 0.7, 0.5, 0.3],
                [0.4, 0.7, 1.0, 0.8, 0.6, 0.4],
                [0.5, 0.8, 0.95, 0.9, 0.7, 0.5],
                [0.3, 0.5, 0.6, 0.7, 0.8, 0.6],
                [0.2, 0.3, 0.5, 0.6, 0.7, 0.5],
            ];

            const cellW = (W - 50) / hours.length;
            const cellH = (H - 30) / days.length;
            const pad = 4;

            // Hour labels
            ctx.fillStyle = '#7a7570';
            ctx.font = '10px JetBrains Mono, monospace';
            ctx.textAlign = 'center';
            hours.forEach((h, j) => {
                ctx.fillText(h, 45 + j * cellW + cellW / 2, 12);
            });

            days.forEach((d, i) => {
                ctx.fillStyle = '#7a7570';
                ctx.font = '11px Source Sans 3, sans-serif';
                ctx.textAlign = 'right';
                ctx.fillText(d, 38, 25 + i * cellH + cellH / 2 + 4);

                hours.forEach((_, j) => {
                    const val = intensities[i][j];
                    const alpha = 0.1 + val * 0.85;
                    ctx.fillStyle = `rgba(204,0,0,${alpha})`;
                    ctx.beginPath();
                    ctx.roundRect(45 + j * cellW + pad, 18 + i * cellH + pad, cellW - pad * 2, cellH - pad *
                        2, 3);
                    ctx.fill();
                });
            });
        }

        // ═══════════════════════════════════════════════════
        // CONTROL FUNCTIONS
        // ═══════════════════════════════════════════════════

        function setPeriod(period, el) {
            currentPeriod = period;
            document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            fetchAndRenderData(period);
        }

        function switchChart(metric, el) {
            currentChartMetric = metric;
            document.querySelectorAll('.chart-period').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            drawChart(metric, currentPeriod);
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2500);
        }

        function loadAllData() {
            // Animate refresh icon
            const icon2 = document.getElementById('refreshIcon2');
            icon2.classList.add('spin');

            fetchAndRenderData(currentPeriod);

            // Update timestamp
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('lastUpdated').textContent = `Terakhir diperbarui: ${timeStr}`;

            setTimeout(() => {
                icon2.classList.remove('spin');
                showToast('✅ Data berhasil diperbarui');
            }, 800);
        }

        // ═══════════════════════════════════════════════════
        // FETCH DATA FROM API
        // ═══════════════════════════════════════════════════

        function fetchAndRenderData(period) {
            const url = `/api/admin/analitik_berita/ambilData?period=${period}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        APP_DATA = data.data;
                        // Render with fetched data
                        renderSummaryCards(APP_DATA.summary);
                        renderTopNews(APP_DATA.topNews);
                        renderViral(APP_DATA.viral);
                        renderCategoryPerf(APP_DATA.categoryPerformance);
                        // Update chart data
                        MOCK_DATA.chart[period] = {
                            labels: APP_DATA.chartData.labels,
                            views: APP_DATA.chartData.views,
                            visitors: APP_DATA.chartData.visitors,
                            comments: APP_DATA.chartData.comments
                        };
                        drawChart(currentChartMetric, period);
                        drawHeatmap();
                    } else {
                        console.error('API Response Error:', data.message);
                        // Fallback to mock data
                        renderSummaryCards();
                        renderTopNews();
                        renderViral();
                        renderCategoryPerf();
                        drawChart(currentChartMetric, currentPeriod);
                        drawHeatmap();
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    // Fallback to mock data on error
                    showToast('⚠️ Menggunakan data lokal');
                    renderSummaryCards();
                    renderTopNews();
                    renderViral();
                    renderCategoryPerf();
                    drawChart(currentChartMetric, currentPeriod);
                    drawHeatmap();
                });
        }

        // ═══════════════════════════════════════════════════
        // INIT
        // ═══════════════════════════════════════════════════

        document.addEventListener('DOMContentLoaded', () => {
            loadAllData();
            // Auto-resize chart on window resize
            window.addEventListener('resize', () => {
                drawChart(currentChartMetric, currentPeriod);
            });
        });
    </script>   
@endsection
