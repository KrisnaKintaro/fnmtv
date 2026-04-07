<header class="topbar">
    <div style="flex:1">
      <div class="tb-title" id="tbTitle">Dashboard</div>
      <div class="tb-breadcrumb" id="tbCrumb">Admin / Dashboard</div>
    </div>
    <div class="search-wrap">
    <svg width="13" height="13" fill="none" stroke="#7a7570" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8" stroke-width="2"/>
        <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2"/>
    </svg>
    <input type="text" id="searchInput" placeholder="Cari data...">
</div>

    <div style="position:relative;">
      <div class="tb-icon" style="overflow: visible;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <span class="tb-dot" style="display:none; position:absolute; top:-6px; right:-6px; background:var(--red, #cc0000); color:white; font-size:10px; font-weight:bold; height:16px; min-width:16px; border-radius:50px; align-items:center; justify-content:center; padding:0 4px; box-sizing:border-box; border: 2px solid white;">0</span>
      </div>

      <div class="notif-panel" id="notifPanel"></div>
    </div>
</header>
