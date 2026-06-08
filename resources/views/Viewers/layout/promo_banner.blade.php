@php
    $tipePromo = $type ?? 'box';
    $promo = $promo ?? null;
    $wrapperId = $id ?? null;
@endphp

{{-- Space promo selalu tampil, JS isi konten kalau ada promo --}}
{{-- Tambahan style max-width dan overflow-hidden agar promo tidak merusak layout HP --}}
<div class="promo-banner promo-{{ $tipePromo }}" @if($wrapperId) id="{{ $wrapperId }}" @endif style="max-width: 100%; overflow: hidden;">
    <div class="promo-label">Promo</div>
    <div class="promo-content" style="max-width: 100%;">
        {{-- Placeholder default kalau belum ada promo --}}
        <div class="promo-placeholder" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background: var(--border, #f0f0f0); border-radius: 8px; color: var(--muted, #aaa); font-size: 13px; text-align: center; padding: 10px;">
            {{ $tipePromo === 'horizontal' ? 'Promo Banner 728x90' : 'Promo Box 300x250' }}
        </div>
    </div>
</div>
