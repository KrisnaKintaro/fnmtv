<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FNM — Verifikasi Sukses</title>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* CSS Konsisten dengan sistem Auth lu */
:root { --red: #cc0000; --red-dark: #990000; --bg: #f5f4f0; --white: #ffffff; --border: #e0ddd6; --text: #1a1a1a; --muted: #7a7570; }
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Source Sans 3',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;}
.login-wrap{position:fixed;inset:0;background:var(--bg);display:flex;align-items:center;justify-content:center;z-index:999;}
.login-card{background:var(--white);border:1px solid var(--border);border-radius:14px;padding:44px 40px;width:100%;max-width:420px;box-shadow:0 8px 40px rgba(0,0,0,.1);text-align:center; animation: pop 0.4s ease-out forwards;}
.login-logo{font-family:'Merriweather',serif;font-size:26px;font-weight:900;color:#1a7a3c;margin-bottom:10px;}
.login-sub{font-size:14px;color:var(--muted);margin-bottom:30px;line-height: 1.6;}
.login-btn{display:flex;align-items:center;justify-content:center;width:100%;padding:13px;background:var(--red);color:#fff;border:none;border-radius:8px;font-family:'Merriweather',serif;font-weight:700;font-size:15px;cursor:pointer;transition:.2s;text-decoration:none;}
.login-btn:hover{background:var(--red-dark);}
@keyframes pop { 0% { transform: scale(0.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
</style>
</head>
<body>

<div class="login-wrap">
  <div class="login-card">
    <div style="font-size: 65px; margin-bottom: 15px;">🎉</div>
    <div class="login-logo">Mantap Cuy!</div>

    <div class="login-sub">
        Email lu udah berhasil diverifikasi dan akun lu udah aktif 100%.<br><br>
        Kalau lu buka link ini dari HP, layar laptop lu harusnya udah otomatis masuk. Klik tombol di bawah kalau lu mau eksplor dari sini!
    </div>

    <a href="/" class="login-btn">🚀 Lanjut ke Beranda</a>
  </div>
</div>

</body>
</html>
