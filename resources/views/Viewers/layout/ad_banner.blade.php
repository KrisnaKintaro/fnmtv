@php
    $tipeIklan = $type ?? 'box';
    $ad = $ad ?? null;
    $wrapperId = $id ?? null;
@endphp

<div class="ad-banner ad-{{ $tipeIklan }}" @if($wrapperId) id="{{ $wrapperId }}" @endif style="max-width: 100%; overflow: hidden;">
    <div class="ad-label">Advertisement</div>
    <div class="ad-content" style="max-width: 100%;">
        {{-- Placeholder default kalau belum ada iklan --}}
        <div class="ad-placeholder" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background: var(--border, #f0f0f0); border-radius: 8px; color: var(--muted, #aaa); font-size: 13px; text-align: center; padding: 10px;">
            Ruang Iklan
        </div>
    </div>
</div>
