@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
  <!-- ══ PAGE: WRITE NEWS (UC-02, UC-04) ══ -->
  <div id="page-write-news" class="page active">
    <div class="section-title">Tulis Berita Baru</div>
    <div class="form-grid">
      <div>
        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Konten Artikel</div>
          <div class="field">
            <label>Judul Berita *</label>
            <input type="text" placeholder="Masukkan judul berita yang menarik...">
          </div>
          <div class="field">
            <label>Slug URL</label>
            <input type="text" placeholder="judul-berita-ini" style="font-family:'JetBrains Mono';font-size:13px;">
          </div>
          <div class="field">
            <label>Ringkasan / Excerpt</label>
            <textarea rows="3" placeholder="Tulis ringkasan singkat berita (maks 160 karakter)..."></textarea>
          </div>
          <div class="field">
            <label>Konten Berita (Rich Text Editor) *</label>
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
                <button class="rte-btn">⚫ List</button>
                <button class="rte-btn">1. List</button>
                <div class="rte-sep"></div>
                <button class="rte-btn">🖼 Gambar</button>
                <button class="rte-btn">🔗 Link</button>
                <button class="rte-btn">❝ Quote</button>
                <button class="rte-btn">⌨ Code</button>
              </div>
              <div class="rte-body" contenteditable="true"></div>
            </div>
          </div>
        </div>
        <div class="form-card">
          <div class="form-title">SEO & Meta</div>
          <div class="field">
            <label>Meta Title</label>
            <input type="text" placeholder="Judul untuk mesin pencari (maks 60 karakter)">
          </div>
          <div class="field">
            <label>Meta Description</label>
            <textarea rows="2" placeholder="Deskripsi untuk mesin pencari (maks 160 karakter)..."></textarea>
          </div>
          <div class="field">
            <label>Tags</label>
            <input type="text" placeholder="politik, kebijakan, ekonomi (pisahkan dengan koma)">
          </div>
        </div>
      </div>

      <div>
        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Publikasi</div>
          <div class="field">
            <label>Status Artikel (UC-04)</label>
            <div class="toggle-group">
              <div class="tgl-opt sel-draft" id="tglDraft" onclick="setStatus('draft')">○ Draft</div>
              <div class="tgl-opt" id="tglPub" onclick="setStatus('pub')">● Published</div>
            </div>
            <p style="font-size:11px;color:var(--muted);margin-top:6px;" id="statusHint">Draft: hanya terlihat oleh admin</p>
          </div>
          <div class="field">
            <label>Jadwal Terbit</label>
            <input type="text" placeholder="Langsung / Jadwalkan..." value="Langsung diterbitkan">
          </div>
          <div class="field">
            <label>Penulis</label>
            <select><option>Budi Santoso</option><option>Rina Agustina</option><option>Arif Wibowo</option></select>
          </div>
          <div style="display:flex;gap:8px;margin-top:4px;">
            <button class="btn btn-outline" style="flex:1;justify-content:center;">Simpan Draft</button>
            <button class="btn btn-red" style="flex:1;justify-content:center;">Publikasikan</button>
          </div>
        </div>

        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Thumbnail Artikel</div>
          <div class="thumb-upload" onclick="alert('Pilih gambar dari komputer')">
            <div class="ico">🖼</div>
            <p><span>Klik untuk upload</span> atau drag & drop</p>
            <p style="margin-top:4px;font-size:11px;">JPG, PNG, WebP • Maks 2MB • Rekomendasi 1200×630px</p>
          </div>
        </div>

        <div class="form-card" style="margin-bottom:16px;">
          <div class="form-title">Kategori & Label</div>
          <div class="field">
            <label>Kategori Utama *</label>
            <select><option>-- Pilih Kategori --</option><option>Politik</option><option>Ekonomi</option><option>Olahraga</option><option>Teknologi</option><option>Kesehatan</option><option>Hiburan</option><option>Sains</option></select>
          </div>
          <div class="field">
            <label>Pilihan Editor</label>
            <label style="text-transform:none;letter-spacing:0;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:7px;font-weight:400;">
              <input type="checkbox"> Tandai sebagai <b>Pilihan Editor</b>
            </label>
          </div>
          <div class="field">
            <label>Berita Trending</label>
            <label style="text-transform:none;letter-spacing:0;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:7px;font-weight:400;">
              <input type="checkbox"> Tandai sebagai <b>Berita Trending</b>
            </label>
          </div>
        </div>

        <div class="form-card">
          <div class="form-title">Finansial Artikel (UC-05)</div>
          <div class="field">
            <label>Nominal Pendapatan</label>
            <input type="number" placeholder="0" style="font-family:'JetBrains Mono'">
            <p style="font-size:11px;color:var(--muted);margin-top:4px;">Input nominal dalam Rupiah (IDR)</p>
          </div>
          <div class="field">
            <label>Status Pembayaran</label>
            <div class="toggle-group">
              <div class="tgl-opt sel-draft" id="tglUnpaid" onclick="setPayStatus('unpaid')">Unpaid</div>
              <div class="tgl-opt" id="tglPaid" onclick="setPayStatus('paid')">Paid</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('js')
@endsection
 
