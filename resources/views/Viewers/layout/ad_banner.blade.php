@php
    $tipeIklan = $type ?? 'box';
    $ad = $ad ?? null;
    $wrapperId = $id ?? null;
@endphp

{{-- Space iklan selalu tampil, JS isi konten kalau ada iklan --}}
<div class="ad-banner ad-{{ $tipeIklan }}" @if($wrapperId) id="{{ $wrapperId }}" @endif>
    <div class="ad-label">Advertisement</div>
    <div class="ad-content">
        {{-- Placeholder default kalau belum ada iklan --}}
        <div class="ad-placeholder" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background: var(--border, #f0f0f0); border-radius: 8px; color: var(--muted, #aaa); font-size: 13px;">
            Ruang Iklan
        </div>
    </div>
</div>