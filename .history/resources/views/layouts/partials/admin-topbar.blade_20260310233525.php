{{-- Topbar shown in admin area --}}
<div class="topbar">
    <div id="tbTitle" class="tb-title">@yield('page_title', 'Dashboard')</div>
    <div id="tbCrumb" class="tb-breadcrumb">@yield('breadcrumb')</div>
    <div class="search-wrap" style="margin-left:20px;">
        <input type="text" placeholder="Search..." />
    </div>
    <div class="tb-icon" onclick="toggleNotif()">🔔<span class="tb-dot"></span></div>
</div>