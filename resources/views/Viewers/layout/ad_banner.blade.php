@php
    // Default valuenya kalau ga diisi pas dipanggil
    $tipeIklan = $type ?? 'box';
    $teksIklan = $text ?? 'SPACE IKLAN 300x250';
@endphp

<div class="ad-banner ad-{{ $tipeIklan }}">
    <div class="ad-label">Advertisement</div>
    <div class="ad-content">{{ $teksIklan }}</div>
</div>
