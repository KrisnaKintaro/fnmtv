function doLogin() {
  const email = document.getElementById('loginEmail').value;
  const pass = document.getElementById('loginPass').value;
  if (email && pass) {
    const lv = document.getElementById('loginView');
    lv.style.transition = 'opacity .4s';
    lv.style.opacity = '0';
    setTimeout(() => { lv.style.display = 'none'; }, 400);
  } else {
    alert('Masukkan email dan password!');
  }
}

function doLogout() {
  if (confirm('Yakin ingin keluar dari panel admin?')) {
    const lv = document.getElementById('loginView');
    lv.style.display = 'flex';
    lv.style.opacity = '0';
    setTimeout(() => { lv.style.opacity = '1'; lv.style.transition = 'opacity .4s'; }, 10);
  }
}

const pageTitles = {
  'dashboard': ['Dashboard', 'Admin / Dashboard'],
  'news-list': ['Manajemen Berita', 'Admin / Berita'],
  'write-news': ['Tulis Berita Baru', 'Admin / Berita / Tulis'],
  'categories': ['Manajemen Kategori', 'Admin / Kategori'],
  'comments': ['Moderasi Komentar', 'Admin / Komentar'],
  'finance': ['Administrasi Finansial', 'Admin / Finansial'],
  'users': ['Manajemen User', 'Admin / User'],
  'settings': ['Pengaturan', 'Admin / Pengaturan'],
};

function showPage(id, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + id).classList.add('active');
  if (el) {
    document.querySelectorAll('.s-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');
  }
  const [title, crumb] = pageTitles[id] || ['—','—'];
  document.getElementById('tbTitle').textContent = title;
  document.getElementById('tbCrumb').textContent = crumb;
}

function toggleNotif() {
  document.getElementById('notifPanel').classList.toggle('open');
}
document.addEventListener('click', e => {
  if (!e.target.closest('.tb-icon') && !e.target.closest('.notif-panel'))
    document.getElementById('notifPanel').classList.remove('open');
});

document.querySelectorAll('.tab-p').forEach(t => {
  t.addEventListener('click', function() {
    this.closest('.tab-pills').querySelectorAll('.tab-p').forEach(x => x.classList.remove('active'));
    this.classList.add('active');
  });
});

function setStatus(v) {
  const d = document.getElementById('tglDraft');
  const p = document.getElementById('tglPub');
  const h = document.getElementById('statusHint');
  if (v === 'draft') {
    d.className = 'tgl-opt sel-draft';
    p.className = 'tgl-opt';
    h.textContent = 'Draft: hanya terlihat oleh admin';
  } else {
    d.className = 'tgl-opt';
    p.className = 'tgl-opt sel-pub';
    h.textContent = 'Published: artikel akan terbit ke publik';
    h.style.color = 'var(--success)';
  }
}
function setPayStatus(v) {
  const u = document.getElementById('tglUnpaid');
  const p = document.getElementById('tglPaid');
  if (v === 'unpaid') {
    u.className = 'tgl-opt sel-draft'; p.className = 'tgl-opt';
  } else {
    u.className = 'tgl-opt'; p.className = 'tgl-opt sel-pub';
  }
}

// Close modals on backdrop click
document.querySelectorAll('.modal-backdrop').forEach(mb => {
  mb.addEventListener('click', e => { if (e.target === mb) mb.classList.remove('open'); });
});