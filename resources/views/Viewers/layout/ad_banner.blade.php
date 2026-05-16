@php
    $tipeIklan = $type ?? 'box';
    $ad = $ad ?? null;
    $wrapperId = $id ?? null;
@endphp

{{-- Tampil by default, JS akan sembunyikan kalau tidak ada iklan --}}
<div class="ad-banner ad-{{ $tipeIklan }}" @if($wrapperId) id="{{ $wrapperId }}" @endif>
    <div class="ad-label">Advertisement</div>
    <div class="ad-content"></div>
</div>