@extends('editor.editor_master')
@section('css')
@endsection
@section('konten')
  <div id="page-write-news" class="page active">
    <div class="section-title">Tulis Berita Baru</div>
    <div class="form-grid">

      <div>
        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Informasi Artikel</div>
          <div class="field">
            <label>Judul Berita *</label>
            <input type="text" placeholder="Masukkan judul berita yang menarik...">
          </div>
          <div class="field">
            <label>Slug URL</label>
            <input type="text" placeholder="judul-berita-menarik" style="font-family:'JetBrains Mono',monospace;font-size:13px;">
          </div>
          <div class="field">
            <label>Konten Berita *</label>
            <div class="rte-mock">
              <div class="rte-toolbar">
                <button class="rte-btn"><b>B</b></button>
                <button class="rte-btn"><i>I</i></button>
                <button class="rte-btn"><u>U</u></button>
                <div class="rte-sep"></div>
                <button class="rte-btn">H1</button>
                <button class="rte-btn">H2</button>
                <button class="rte-btn">H3</button>
                <div class="rte-sep"></div>
                <button class="rte-btn">≡</button>
                <button class="rte-btn">≣</button>
                <button class="rte-btn">⊶</button>
                <div class="rte-sep"></div>
                <button class="rte-btn">🔗</button>
                <button class="rte-btn">🖼</button>
                <button class="rte-btn">❝</button>
              </div>
              <div class="rte-body" contenteditable="true"></div>
            </div>
          </div>
        </div>
      </div>

      <div>
        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Status Pengiriman</div>
          <div class="field" style="margin-bottom:0;">
            <label>Kirim sebagai</label>
            <div class="toggle-group">
              <div class="tgl-opt sel-draft" id="tglDraft" onclick="confirmStatus('draft')">Draft</div>
              <div class="tgl-opt" id="tglPending" onclick="confirmStatus('pending')">Kirim ke Redaksi</div>
            </div>
          </div>
        </div>

        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Thumbnail Berita</div>
          <div class="thumb-upload">
            <div class="ico">🖼</div>
            <p><span>Pilih file</span> atau seret ke sini</p>
            <p style="font-size:11px;margin-top:4px;">JPG, PNG, JPEG · Maks. 2 MB</p>
          </div>
        </div>

        <div class="form-card">
          <div class="form-title">Kategori</div>
          <div class="field" style="margin-bottom:0;">
            <label>Pilih Kategori *</label>
            <select>
              <option value="">-- Pilih Kategori --</option>
              <option>Politik</option>
              <option>Ekonomi</option>
              <option>Teknologi</option>
              <option>Olahraga</option>
              <option>Kesehatan</option>
              <option>Budaya</option>
              <option>Internasional</option>
            </select>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div id="modalDraft" style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
    <div style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
      <div style="font-size:32px;text-align:center;margin-bottom:12px;">📝</div>
      <div style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">Simpan sebagai Draft?</div>
      <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan disimpan sebagai draft dan hanya terlihat oleh Anda. Anda bisa mengedit dan mengirimnya kapan saja.</div>
      <div style="display:flex;gap:10px;">
        <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('draft')">Batal</button>
        <button class="btn btn-ghost" style="flex:1;" onclick="applyStatus('draft')">Ya, Simpan Draft</button>
      </div>
    </div>
  </div>

  <div id="modalPending" style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
    <div style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
      <div style="font-size:32px;text-align:center;margin-bottom:12px;">📨</div>
      <div style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">Kirim ke Redaksi?</div>
      <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan dikirim ke Redaksi untuk diverifikasi dan diterbitkan. Pastikan artikel sudah siap sebelum melanjutkan.</div>
      <div style="display:flex;gap:10px;">
        <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('pending')">Batal</button>
        <button class="btn btn-blue" style="flex:1;" onclick="applyStatus('pending')">
          <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
          Ya, Kirim
        </button>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script>
  function confirmStatus(v) {
    const draftBtn = document.getElementById('tglDraft');
    const pendingBtn = document.getElementById('tglPending');

    if (v === 'draft') {
      draftBtn.classList.add('sel-draft');
      draftBtn.classList.remove('sel-pending');
      pendingBtn.classList.remove('sel-pending');
      document.getElementById('modalDraft').style.display = 'flex';
    } else {
      pendingBtn.classList.add('sel-pending');
      pendingBtn.classList.remove('sel-draft');
      draftBtn.classList.remove('sel-draft');
      document.getElementById('modalPending').style.display = 'flex';
    }
  }

  function closeStatusModal(v) {
    if (v === 'draft') {
      document.getElementById('modalDraft').style.display = 'none';
      document.getElementById('tglDraft').classList.remove('sel-draft');
      document.getElementById('tglPending').classList.add('sel-pending');
    } else {
      document.getElementById('modalPending').style.display = 'none';
      document.getElementById('tglDraft').classList.add('sel-draft');
      document.getElementById('tglPending').classList.remove('sel-pending');
    }
  }

  function applyStatus(v) {
    if (v === 'draft') {
      document.getElementById('modalDraft').style.display = 'none';
    } else {
      document.getElementById('modalPending').style.display = 'none';
    }
  }
</script>
@endsection
 
