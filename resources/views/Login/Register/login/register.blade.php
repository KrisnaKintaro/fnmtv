<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FNM — Register</title>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --red: #cc0000;
  --red-dark: #990000;
  --bg: #f5f4f0;
  --white: #ffffff;
  --surface2: #f0eeea;
  --border: #e0ddd6;
  --text: #1a1a1a;
  --muted: #7a7570;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Source Sans 3',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;}

/* ── REGISTER ── */
.login-wrap{position:fixed;inset:0;background:var(--bg);display:flex;align-items:center;justify-content:center;z-index:999;transition:opacity .4s;}
.login-card{background:var(--white);border:1px solid var(--border);border-radius:14px;padding:44px 40px;width:100%;max-width:420px;box-shadow:0 8px 40px rgba(0,0,0,.1);}
.login-logo{font-family:'Merriweather',serif;font-size:32px;font-weight:900;color:var(--red);text-align:center;margin-bottom:2px;}
.login-sub{text-align:center;font-size:13px;color:var(--muted);margin-bottom:24px;}
.login-role-chip{text-align:center;margin-bottom:24px;}
.login-role-chip span{display:inline-flex;align-items:center;gap:6px;background:#e6f4ec;color:#1a7a3c;font-size:12px;font-weight:700;padding:5px 14px;border-radius:20px;}
.lfield{margin-bottom:16px;}
.lfield label{font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:6px;}
.lfield input{width:100%;border:1.5px solid var(--border);border-radius:7px;padding:10px 13px;font-family:inherit;font-size:14px;color:var(--text);outline:none;transition:.15s;}
.lfield input:focus{border-color:var(--red);}
.login-btn{width:100%;padding:13px;background:var(--red);color:#fff;border:none;border-radius:8px;font-family:'Merriweather',serif;font-weight:700;font-size:15px;cursor:pointer;transition:.2s;margin-top:6px;}
.login-btn:hover{background:var(--red-dark);}
.login-foot{text-align:center;font-size:12px;color:var(--muted);margin-top:18px;}
.toggle-link{text-decoration:none;color:var(--red);font-weight:600;}
.toggle-link:hover{text-decoration:underline;}

/* ── TOAST ── */
#toast{position:fixed;bottom:28px;right:28px;background:#1a1a1a;color:#fff;padding:12px 20px;border-radius:8px;font-size:13px;font-weight:600;display:none;align-items:center;gap:10px;box-shadow:0 6px 28px rgba(0,0,0,.25);z-index:9999;min-width:250px;transition:opacity .3s;}
</style>
</head>
<body>

<!-- REGISTER FORM -->
<div class="login-wrap">
  <div class="login-card">
    <div class="login-logo">FNM</div>
    <div class="login-sub">Fenomena News Media — Platform Berita Terpercaya</div>
    <div class="login-role-chip">
      <span>✍️ Daftar Akun Baru</span>
    </div>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="lfield">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
        @error('name')
          <span style="color:var(--red);font-size:11px;margin-top:3px;display:block;">{{ $message }}</span>
        @enderror
      </div>
      <div class="lfield">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan email" required value="{{ old('email') }}">
        @error('email')
          <span style="color:var(--red);font-size:11px;margin-top:3px;display:block;">{{ $message }}</span>
        @enderror
      </div>
      <div class="lfield">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        @error('password')
          <span style="color:var(--red);font-size:11px;margin-top:3px;display:block;">{{ $message }}</span>
        @enderror
      </div>
      <div class="lfield">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
        @error('password_confirmation')
          <span style="color:var(--red);font-size:11px;margin-top:3px;display:block;">{{ $message }}</span>
        @enderror
      </div>
      <button type="submit" class="login-btn">Daftar</button>
    </form>
    <div class="login-foot">
      Sudah punya akun? <a href="{{ route('login') }}" class="toggle-link">Masuk di sini</a>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast">
  <span id="toastIco">✅</span>
  <span id="toastMsg">—</span>
</div>

<script>
// Toast function
let toastTimer;
function showToast(ico, msg) {
  clearTimeout(toastTimer);
  const t = document.getElementById('toast');
  document.getElementById('toastIco').textContent = ico;
  document.getElementById('toastMsg').textContent = msg;
  t.style.display = 'flex'; t.style.opacity = '1';
  toastTimer = setTimeout(() => {
    t.style.opacity = '0';
    setTimeout(() => { t.style.display = 'none'; }, 300);
  }, 3000);
}

// Show toast if there are errors
@if ($errors->any())
  showToast('❌', '{{ $errors->first() }}');
@endif

@if (session('success'))
  showToast('✅', '{{ session('success') }}');
@endif
</script>

</body>
</html>