// Menampilkan Toast
function showToast(msg, duration = 2500) {
    const t = document.getElementById('toast');
    if(t) {
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), duration);
    }
}

// Buka Sosmed
function openSocial(platform) {
    const urls = {
        facebook: 'https://facebook.com',
        instagram: 'https://instagram.com',
        twitter: 'https://twitter.com',
        whatsapp: 'https://wa.me',
    };
    if (urls[platform]) window.open(urls[platform], '_blank');
}

// Format Angka (1.5K, 2M)
function fmtNum(n) {
    const num = typeof n === 'string' ? parseFloat(n) : n;
    if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
    if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
    return num.toFixed ? num.toFixed(0) : String(num);
}

// Handle Dropdown Menu Lainnya
function toggleNavMore() {
    const d = document.getElementById('navMoreDropdown');
    if(d) d.classList.toggle('open');
}

// Handle Pencarian
function handleSearchKey(e) {
    if (e.key === 'Enter') doSearch();
}

function doSearch() {
    const q = document.getElementById('searchInput').value.trim();
    if (!q) return;
    // Arahkan ke halaman pencarian bawaan Laravel
    window.location.href = '/search?q=' + encodeURIComponent(q);
}

// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const navMore = document.getElementById('navMore');
    const drop = document.getElementById('navMoreDropdown');
    if (navMore && drop && !navMore.contains(e.target)) {
        drop.classList.remove('open');
    }
});
