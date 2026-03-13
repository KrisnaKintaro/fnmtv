// ── VIEW COUNTER SIMULATION (UC-14) ──
const viewData = {};
function incrementView(slug) {
  if (!viewData[slug]) viewData[slug] = Math.floor(Math.random()*50000)+1000;
  viewData[slug]++;
  return viewData[slug];
}
function fmtNum(n) {
  if (n >= 1000) return (n/1000).toFixed(1)+'K';
  return n.toString();
}

// ── ARTICLE DATA ──
const articles = {
  'berkas-epstein':{cat:'Pilihan Editor',title:'Berkas Epstein memicu era baru teori konspirasi',author:'Budi Santoso',avatar:'B',hero:'🕵️',views:'84.2K',cmt:47},
  'komisi-x':{cat:'Politik',title:'Komisi X DPR Ingatkan Alumni: "Cukup Aku yang Urus WN? LPDP Dana Publik"',author:'Rina Agustina',avatar:'R',hero:'🏛️',views:'18.4K',cmt:12},
  'gajah-sumatera':{cat:'Lingkungan',title:'Gajah Sumatera 20 Tahun Mati Diduga Terlilit Kawat Listrik di Aceh',author:'Dewi Puspita',avatar:'D',hero:'🐘',views:'9.7K',cmt:8},
  'seskab-teddy':{cat:'Politik',title:'Seskab Teddy: Tidak Benar Produk AS Masuk Indonesia Tanpa Sertifikasi Halal',author:'Budi Santoso',avatar:'B',hero:'👔',views:'12.3K',cmt:31},
  'aksi-brimob':{cat:'Hukum & Kriminal',title:'Aksi Brutal Oknum Brimob Aniaya Siswa Pakai Helm hingga Tewas di Tual',author:'Rina Agustina',avatar:'R',hero:'👮',views:'14.2K',cmt:64},
  'polisi-muda':{cat:'Kriminal',title:'Polisi Muda di Sulsel Tewas di Barak, Kompolnas Desak Pengusutan',author:'Dewi Puspita',avatar:'D',hero:'🚔',views:'9.8K',cmt:22},
  'guru-honorer':{cat:'Pendidikan',title:'Ketika Guru Honorer Dipecat, Rangkap Jabatan Elite Tetap Lemah',author:'Sari Maharani',avatar:'S',hero:'🎓',views:'7.3K',cmt:19},
  'rupiah-as':{cat:'Ekonomi',title:'Rupiah Dibuka Menguat Pagi Ini AS Batalkan Tarif Trump',author:'Arif Wibowo',avatar:'A',hero:'💵',views:'42.1K',cmt:87},
  'prabowo-bilateral':{cat:'Politik',title:'Seskab Teddy: Prabowo Satu-satunya Kepala Negara Gelar Bilateral',author:'Budi Santoso',avatar:'B',hero:'🤝',views:'38.7K',cmt:53},
  'ucapan-imlek':{cat:'Budaya',title:'100 Ucapan Imlek 2026 Penuh Harapan dan Keberuntungan',author:'Sari Maharani',avatar:'S',hero:'🧧',views:'35.2K',cmt:29},
  'ihsg-menguat':{cat:'Ekonomi',title:'Update Harga Emas Hartatinata Abadi 23 Februari 2026',author:'Arif Wibowo',avatar:'A',hero:'📈',views:'8.4K',cmt:7},
  'psm-dihukum':{cat:'Olahraga',title:'Persebaya Dihantam Dua Kekalahan, Tawuran Putar Otak Hadapi PSM',author:'Rina Agustina',avatar:'R',hero:'⚽',views:'22.1K',cmt:41},
  'sulawesi-gempa':{cat:'Bencana',title:'Rehabilitasi 32 Daerah Terdampak Bencana Sumatera Butuh Waktu Panjang',author:'Dewi Puspita',avatar:'D',hero:'🌊',views:'11.3K',cmt:15},
  'teknologi-ai':{cat:'Teknologi',title:'Peneliti Dunia Sepakati Regulasi AI Baru untuk Cegah Penyalahgunaan Data',author:'Arif Wibowo',avatar:'A',hero:'🤖',views:'6.7K',cmt:18},
  'kesehatan-jantung':{cat:'Kesehatan',title:'Studi Terbaru: Jalan Kaki 30 Menit Sehari Turunkan Risiko Jantung 40%',author:'Sari Maharani',avatar:'S',hero:'❤️',views:'19.4K',cmt:33},
};

function openArticle(slug) {
  const a = articles[slug] || articles['berkas-epstein'];
  const vCount = incrementView(slug);
  document.getElementById('artCat').textContent = a.cat;
  document.getElementById('artTitle').textContent = a.title;
  document.getElementById('artAuthor').textContent = a.author;
  document.getElementById('artAvatar').textContent = a.avatar;
  document.getElementById('artHero').textContent = a.hero;
  document.getElementById('artDate').textContent = '10 Maret 2026, 09:41 WIB';
  document.getElementById('viewCount').textContent = fmtNum(vCount);
  document.getElementById('cmtCount').textContent = a.cmt;
  document.getElementById('totalCmt').textContent = '3';
  // Reset reactions
  document.querySelectorAll('.reaction-btn').forEach(r => r.classList.remove('active'));
  document.getElementById('rb-like').classList.add('active');
  document.getElementById('homeView').style.display = 'none';
  document.getElementById('articleView').style.display = 'block';
  window.scrollTo({top:0,behavior:'smooth'});
}

function goHome() {
  document.getElementById('homeView').style.display = 'block';
  document.getElementById('articleView').style.display = 'none';
  document.getElementById('searchResults').classList.remove('active');
  window.scrollTo({top:0,behavior:'smooth'});
}

function react(type) {
  document.querySelectorAll('.reaction-btn').forEach(r => r.classList.remove('active'));
  const btn = document.getElementById('rb-'+type);
  btn.classList.add('active');
  const countEl = document.getElementById('rc-'+type);
  countEl.textContent = parseInt(countEl.textContent) + 1;
}

function submitComment() {
  const name = document.getElementById('cmtName').value.trim() || 'Anonim';
  const text = document.getElementById('cmtInput').value.trim();
  if (!text) { alert('Tulis komentar terlebih dahulu!'); return; }
  const list = document.getElementById('commentsList');
  const div = document.createElement('div');
  div.className = 'comment-item';
  div.style.animation = 'slideIn .3s ease';
  div.innerHTML = `<div class="ci-avatar" style="background:var(--red);color:#fff">${name[0].toUpperCase()}</div><div class="ci-body"><div class="ci-user">${name} <span style="background:#e6f4ec;color:#1a7a3c;font-size:10px;padding:2px 6px;border-radius:8px;font-weight:700;margin-left:6px;">Baru</span></div><div class="ci-time">Baru saja</div><div class="ci-text">${text}</div><div class="ci-acts"><span class="ci-act">👍 Suka (0)</span><span class="ci-act">↩ Balas</span></div></div>`;
  list.prepend(div);
  document.getElementById('cmtInput').value = '';
  const t = document.getElementById('totalCmt');
  t.textContent = parseInt(t.textContent) + 1;
}

function doSearch() {
  const q = document.getElementById('searchInput').value.trim();
  if (!q) return;
  document.getElementById('srTitle').textContent = `Hasil pencarian: "${q}"`;
  const matches = Object.entries(articles).filter(([k,v]) => v.title.toLowerCase().includes(q.toLowerCase()));
  document.getElementById('srSub').textContent = `Ditemukan ${matches.length} berita`;
  const html = matches.length ? matches.map(([k,v]) => `
    <div class="news-list-item" onclick="openArticle('${k}')">
      <div class="nli-img">${v.hero}</div>
      <div><div class="nli-cat">${v.cat}</div><div class="nli-title">${v.title}</div><div class="nli-meta">${v.author} · ${v.views} views</div></div>
    </div>`).join('') : '<div class="empty-state"><div class="ei">🔍</div>Tidak ada berita ditemukan untuk kata kunci tersebut.</div>';
  document.getElementById('srContent').innerHTML = html;
  document.getElementById('searchResults').classList.add('active');
  window.scrollTo({top:0,behavior:'smooth'});
}

function setNav(el, cat) {
  if (el) {
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    el.classList.add('active');
  }
  document.getElementById('homeView').style.display = 'block';
  document.getElementById('articleView').style.display = 'none';
}

function filterTop(type) {
  document.querySelectorAll('.ts-link').forEach(t => t.classList.remove('active'));
  document.getElementById('ts'+type.charAt(0).toUpperCase()+type.slice(1))?.classList.add('active');
  const map = {terkini:'tsBeritaTerkini',populer:'tsBeritaPopuler',editor:'tsPilihanEditor',artikel:'tsArtikel'};
  const el = document.getElementById(map[type]);
  if (el) el.classList.add('active');
}