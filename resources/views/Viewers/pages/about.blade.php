@extends('viewers.master_viewers')

@section('title', 'Tentang Kami - FNM')

@section('konten')
@php
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Iklan;
use App\Models\User;
use App\Models\ViewLog;
use Illuminate\Support\Str;

$activeReaders = ViewLog::distinct('ip_address')->count('ip_address');
$publishedArticles = Berita::where('status_berita', 'Published')->count();
$categoryCount = Kategori::count();
$yearEstablished = 2022;
$activeAds = Iklan::where('is_active', true)->latest()->take(3)->get();
$trendingArticles = Berita::where('status_berita', 'Published')
    ->with('kategori', 'user')
    ->orderBy('jumlah_view', 'desc')
    ->take(5)
    ->get();

$teamMembers = collect([
    [
        'nama' => 'Bayu Nugroho',
        'jabatan' => 'Pemimpin Redaksi',
        'role' => 'Redaksi',
        'inisial' => 'BN',
        'warna' => '#faeeda',
        'warna_teks' => '#854f0b'
    ]
]);

$loadedUsers = User::whereIn('role', ['Admin', 'Editor', 'Redaksi'])
    ->orderByRaw("FIELD(role, 'Admin', 'Editor', 'Redaksi')")
    ->take(5)
    ->get();

foreach ($loadedUsers as $user) {
    if (strtolower($user->username) === strtolower('Bayu Nugroho')) {
        continue;
    }
    $roleLabel = $user->role === 'Admin' ? 'Administrator' : ($user->role === 'Editor' ? 'Editor' : 'Redaksi');
    $teamMembers->push([
        'nama' => $user->username ?? 'User',
        'jabatan' => $roleLabel,
        'role' => $user->role,
        'inisial' => strtoupper(substr($user->username ?? 'U', 0, 1)),
        'warna' => $user->role === 'Admin' ? '#eeedfe' : '#e6f1fb',
        'warna_teks' => $user->role === 'Admin' ? '#534ab7' : '#185fa5'
    ]);
}


$teamMembers = $teamMembers->take(6);
@endphp

<div class="container page-anim">
    <div class="main-grid">
        <div class="main-content">

            {{-- HERO --}}
            <div style="padding:48px 0 36px; border-bottom:0.5px solid var(--border); margin-bottom:36px;">
                <div style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--red);font-weight:500;margin-bottom:8px;">Tentang Kami</div>
                <h1 style="font-family:'Merriweather',serif;font-size:32px;font-weight:700;line-height:1.2;margin:0 0 14px;">
                    Kami adalah <span style="color:var(--red);">FNM</span> —<br>Suara yang Anda percaya
                </h1>
                <p style="font-size:15px;color:var(--muted);line-height:1.7;max-width:560px;">
                    FNM hadir sebagai media digital independen yang berkomitmen menyajikan berita akurat, cepat, dan berimbang untuk masyarakat Indonesia.
                </p>
            </div>

            {{-- IKLAN AKTIF --}}
            <div style="margin-bottom:40px;">
                <div style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--red);font-weight:500;margin-bottom:8px;">Iklan Aktif</div>
                <h2 style="font-family:'Merriweather',serif;font-size:22px;font-weight:700;margin:0 0 16px;">Kampanye dan promosi terbaru yang sedang tampil</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;margin-bottom:24px;">
                    @forelse($activeAds as $ad)
                        <div style="background:var(--surface);border-radius:16px;overflow:hidden;border:1px solid var(--border);">
                            <div style="height:140px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f7f7f7;">
                                <img src="{{ asset('uploads/iklan/' . $ad->gambar) }}" alt="{{ $ad->judul }}" style="width:100%;height:100%;object-fit:cover;" />
                            </div>
                            <div style="padding:16px;">
                                <div style="font-size:15px;font-weight:700;margin-bottom:6px;">{{ $ad->judul }}</div>
                                <div style="font-size:12px;color:var(--muted);margin-bottom:12px;">Posisi: {{ ucwords(str_replace(['_','-'], ' ', $ad->posisi)) }}</div>
                                @if($ad->link_tujuan)
                                    <a href="{{ $ad->link_tujuan }}" target="_blank" style="display:inline-block;padding:8px 12px;border-radius:8px;background:var(--red);color:#fff;font-size:12px;text-decoration:none;">Lihat Iklan</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="grid-column:1/-1;padding:28px 16px;background:var(--surface);border-radius:16px;text-align:center;color:var(--muted);">Belum ada iklan aktif saat ini.</div>
                    @endforelse
                </div>
            </div>

            {{-- STATISTIK --}}
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:40px;">
                <div style="background:var(--surface);border-radius:8px;padding:16px;text-align:center;">
                    <div style="font-size:26px;font-weight:700;color:var(--red);line-height:1;margin-bottom:6px;">{{ number_format($activeReaders) }}</div>
                    <div style="font-size:12px;color:var(--muted);">Pembaca aktif</div>
                </div>
                <div style="background:var(--surface);border-radius:8px;padding:16px;text-align:center;">
                    <div style="font-size:26px;font-weight:700;color:var(--red);line-height:1;margin-bottom:6px;">{{ number_format($publishedArticles) }}</div>
                    <div style="font-size:12px;color:var(--muted);">Artikel diterbitkan</div>
                </div>
                <div style="background:var(--surface);border-radius:8px;padding:16px;text-align:center;">
                    <div style="font-size:26px;font-weight:700;color:var(--red);line-height:1;margin-bottom:6px;">{{ number_format($categoryCount) }}</div>
                    <div style="font-size:12px;color:var(--muted);">Kategori berita</div>
                </div>
                <div style="background:var(--surface);border-radius:8px;padding:16px;text-align:center;">
                    <div style="font-size:26px;font-weight:700;color:var(--red);line-height:1;margin-bottom:6px;">{{ $yearEstablished }}</div>
                    <div style="font-size:12px;color:var(--muted);">Tahun berdiri</div>
                </div>
            </div>

            {{-- VISI MISI --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:40px;">
                <div style="border:1px solid var(--border);border-radius:12px;padding:20px;">
                    <div style="font-size:20px;margin-bottom:10px;">🎯</div>
                    <div style="font-size:15px;font-weight:700;margin-bottom:8px;">Visi</div>
                    <div style="font-size:13px;color:var(--muted);line-height:1.6;">Menjadi media digital terpercaya yang mendorong literasi informasi masyarakat Indonesia.</div>
                </div>
                <div style="border:1px solid var(--border);border-radius:12px;padding:20px;">
                    <div style="font-size:20px;margin-bottom:10px;">📋</div>
                    <div style="font-size:15px;font-weight:700;margin-bottom:8px;">Misi</div>
                    <div style="font-size:13px;color:var(--muted);line-height:1.6;">Menyajikan berita yang cepat, akurat, dan berimbang dengan standar jurnalisme profesional.</div>
                </div>
            </div>

            {{-- SEDANG TREND --}}
            <div style="margin-bottom:40px;">
                <div style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--red);font-weight:500;margin-bottom:8px;">Sedang Trend</div>
                <h2 style="font-family:'Merriweather',serif;font-size:22px;font-weight:700;margin:0 0 4px;">Berita yang sedang banyak dibaca</h2>
                <div style="width:40px;height:2px;background:var(--red);margin:12px 0 24px;border-radius:2px;"></div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;margin-bottom:40px;">
                @forelse($trendingArticles as $item)
                    @php
                        $cat = $item->kategori ? $item->kategori->nama_kategori : 'Umum';
                        $img = $item->foto_thumbnail;
                        if ($img && !str_starts_with($img, 'http')) {
                            $img = '/uploads/thumbnail/' . $img;
                        }
                        $penulis = $item->user ? $item->user->username : 'Redaksi';
                    @endphp
                    <a href="/berita/{{ $item->slug }}" style="text-decoration:none;cursor:pointer;">
                        <div style="background:#fff;border:1px solid var(--border);border-radius:12px;overflow:hidden;transition:all 0.3s;cursor:pointer;">
                            <div style="height:150px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f7f7f7;">
                                @if($img)
                                    <img src="{{ $img }}" alt="{{ $item->judul_berita }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy" />
                                @else
                                    <div style="font-size:48px;">📰</div>
                                @endif
                            </div>
                            <div style="padding:16px;">
                                <div style="display:inline-block;padding:4px 10px;background:{{ $cat === 'Umum' ? '#f0f0f0' : '#e6f1fb' }};color:{{ $cat === 'Umum' ? '#555' : '#185fa5' }};border-radius:6px;font-size:10px;font-weight:700;margin-bottom:10px;">
                                    {{ $cat }}
                                </div>
                                <div style="font-size:14px;font-weight:700;color:var(--text);line-height:1.4;margin-bottom:8px;">{{ Str::limit($item->judul_berita, 60) }}</div>
                                <div style="font-size:12px;color:var(--muted);margin-bottom:10px;">Oleh {{ $penulis }} • {{ $item->created_at->diffForHumans() }}</div>
                                <div style="font-size:12px;color:var(--red);font-weight:700;">👁 {{ number_format($item->jumlah_view) }} Dibaca</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="grid-column:1/-1;padding:28px 16px;background:var(--surface);border-radius:16px;text-align:center;color:var(--muted);">Belum ada berita untuk ditampilkan.</div>
                @endforelse
            </div>

            {{-- TIM --}}
            <div style="margin-bottom:8px;">
                <div style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--red);font-weight:500;margin-bottom:8px;">Tim Redaksi</div>
                <h2 style="font-family:'Merriweather',serif;font-size:22px;font-weight:700;margin:0 0 4px;">Orang-orang di balik FNM</h2>
                <div style="width:40px;height:2px;background:var(--red);margin:12px 0 24px;border-radius:2px;"></div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:16px;margin-bottom:40px;">
                @foreach($teamMembers as $anggota)
                <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px 16px;text-align:center;">
                    <div style="width:56px;height:56px;border-radius:50%;background:{{ $anggota['warna'] }};color:{{ $anggota['warna_teks'] }};display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;margin:0 auto 12px;">
                        {{ $anggota['inisial'] }}
                    </div>
                    <div style="font-size:14px;font-weight:700;margin-bottom:4px;">{{ $anggota['nama'] }}</div>
                    <div style="font-size:12px;color:var(--muted);margin-bottom:10px;">{{ $anggota['jabatan'] }}</div>
                    <span style="font-size:11px;padding:3px 10px;border-radius:20px;background:{{ $anggota['warna'] }};color:{{ $anggota['warna_teks'] }};">
                        {{ $anggota['role'] }}
                    </span>
                </div>
                @endforeach
            </div>

        </div>

        <div class="sidebar-col">
            @include('viewers.layout.sidebar')
        </div>
    </div>
</div>
@endsection