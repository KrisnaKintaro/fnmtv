@extends('Viewers.master_viewers')
@section('css')
@endsection
@section('konten')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FNM — Fenomena News Media</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;0,900;1,400&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
            rel="stylesheet">
        <style>
            :root {
                --red: #cc0000;
                --red-dark: #990000;
                --white: #fff;
                --bg: #f5f4f0;
                --border: #ddd9d0;
                --text: #1a1a1a;
                --muted: #7a7570;
                --surface: #fff;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Source Sans 3', sans-serif;
                background: var(--bg);
                color: var(--text);
            }

            a {
                text-decoration: none;
                color: inherit;
            }

            /* ── TOP STRIP ── */
            .topstrip {
                background: var(--red);
                color: #fff;
                font-size: 12px;
                letter-spacing: .3px;
                display: flex;
                align-items: center;
            }

            .ts-inner {
                max-width: 1180px;
                margin: 0 auto;
                width: 100%;
                padding: 7px 20px;
                display: flex;
                align-items: center;
            }

            .ts-links {
                display: flex;
                gap: 0;
            }

            .ts-link {
                padding: 0 14px 0 0;
                margin: 0 14px 0 0;
                border-right: 1px solid rgba(255, 255, 255, .3);
                font-weight: 600;
                cursor: pointer;
                transition: .15s;
                user-select: none;
            }

            .ts-link:last-child {
                border-right: none;
            }

            .ts-link:hover {
                opacity: .75;
            }

            .ts-link.active {
                text-decoration: underline;
                text-underline-offset: 3px;
            }

            .ts-socials {
                margin-left: auto;
                display: flex;
                gap: 12px;
            }

            .ts-social {
                width: 26px;
                height: 26px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .15);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                cursor: pointer;
                transition: .15s;
            }

            .ts-social:hover {
                background: rgba(255, 255, 255, .3);
            }

            /* ── HEADER ── */
            .header {
                background: var(--white);
                border-bottom: 2px solid var(--text);
                position: relative;
                z-index: 200;
            }

            .header-inner {
                max-width: 1180px;
                margin: 0 auto;
                padding: 14px 20px;
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .logo {
                font-family: 'Merriweather', serif;
                font-size: 36px;
                font-weight: 900;
                color: var(--red);
                letter-spacing: -2px;
                flex-shrink: 0;
                cursor: pointer;
            }

            .header-tagline {
                font-size: 12px;
                color: var(--muted);
                border-left: 2px solid var(--border);
                padding-left: 14px;
                line-height: 1.5;
            }

            .header-search {
                margin-left: auto;
                display: flex;
                gap: 0;
                position: relative;
            }

            .search-input {
                border: 1.5px solid var(--border);
                border-right: none;
                border-radius: 5px 0 0 5px;
                padding: 8px 14px;
                font-family: inherit;
                font-size: 13px;
                outline: none;
                width: 260px;
                transition: .15s;
            }

            .search-input:focus {
                border-color: var(--red);
            }

            .search-btn {
                background: var(--red);
                color: #fff;
                border: none;
                border-radius: 0 5px 5px 0;
                padding: 8px 14px;
                cursor: pointer;
                font-size: 14px;
                transition: .15s;
            }

            .search-btn:hover {
                background: var(--red-dark);
            }

            /* Search Dropdown */
            .search-dropdown {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--white);
                border: 1.5px solid var(--red);
                border-top: none;
                border-radius: 0 0 8px 8px;
                max-height: 360px;
                overflow-y: auto;
                z-index: 9999;
                box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
                display: none;
            }

            .search-dropdown.open {
                display: block;
            }

            .sd-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 14px;
                cursor: pointer;
                border-bottom: 1px solid var(--border);
                transition: .15s;
            }

            .sd-item:last-child {
                border-bottom: none;
            }

            .sd-item:hover {
                background: #fde8e826;
            }

            .sd-emoji {
                font-size: 22px;
                width: 34px;
                height: 34px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--bg);
                border-radius: 4px;
                flex-shrink: 0;
            }

            .sd-info {
                flex: 1;
            }

            .sd-cat {
                font-size: 10px;
                font-weight: 700;
                color: var(--red);
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .sd-title {
                font-size: 13px;
                font-weight: 600;
                line-height: 1.35;
            }

            .sd-meta {
                font-size: 11px;
                color: var(--muted);
                margin-top: 2px;
            }

            .sd-empty {
                padding: 20px;
                text-align: center;
                color: var(--muted);
                font-size: 13px;
            }

            .sd-header {
                padding: 8px 14px;
                font-size: 11px;
                font-weight: 700;
                color: var(--muted);
                text-transform: uppercase;
                letter-spacing: 1px;
                background: var(--bg);
                border-bottom: 1px solid var(--border);
            }

            /* ── NAV ── */
            .nav {
                background: var(--white);
                border-bottom: 1px solid var(--border);
                position: sticky;
                top: 0;
                z-index: 100;
            }

            .nav-inner {
                max-width: 1180px;
                margin: 0 auto;
                padding: 0 20px;
                display: flex;
                align-items: center;
            }

            .nav-item {
                padding: 13px 16px;
                font-size: 13.5px;
                font-weight: 600;
                cursor: pointer;
                border-bottom: 3px solid transparent;
                transition: .15s;
                white-space: nowrap;
                letter-spacing: .3px;
                user-select: none;
            }

            .nav-item:hover {
                color: var(--red);
            }

            .nav-item.active {
                color: var(--red);
                border-bottom-color: var(--red);
            }

            .nav-more {
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 10px 14px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                border: 1.5px solid var(--border);
                border-radius: 5px;
                transition: .15s;
                position: relative;
            }

            .nav-more:hover {
                border-color: var(--red);
                color: var(--red);
            }

            .nav-more-dropdown {
                position: absolute;
                top: calc(100% + 8px);
                right: 0;
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: 8px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
                min-width: 180px;
                z-index: 9999;
                display: none;
                overflow: hidden;
            }

            .nav-more-dropdown.open {
                display: block;
            }

            .nmd-item {
                padding: 11px 16px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                transition: .15s;
                display: flex;
                align-items: center;
                gap: 8px;
                border-bottom: 1px solid var(--border);
            }

            .nmd-item:last-child {
                border-bottom: none;
            }

            .nmd-item:hover {
                background: var(--bg);
                color: var(--red);
            }

            /* ── FILTER BAR (category page) ── */
            .filter-bar {
                background: var(--white);
                border-bottom: 1px solid var(--border);
                padding: 10px 0;
            }

            .filter-bar-inner {
                max-width: 1180px;
                margin: 0 auto;
                padding: 0 20px;
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
            }

            .filter-label {
                font-size: 12px;
                font-weight: 700;
                color: var(--muted);
                margin-right: 4px;
            }

            .filter-chip {
                padding: 5px 12px;
                border-radius: 20px;
                border: 1.5px solid var(--border);
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                transition: .15s;
                background: var(--bg);
            }

            .filter-chip:hover {
                border-color: var(--red);
                color: var(--red);
            }

            .filter-chip.active {
                background: var(--red);
                border-color: var(--red);
                color: #fff;
            }

            /* ── MAIN LAYOUT ── */
            .container {
                max-width: 1180px;
                margin: 0 auto;
                padding: 24px 20px;
            }

            .main-grid {
                display: grid;
                grid-template-columns: 1fr 300px;
                gap: 28px;
            }

            /* ── HERO ── */
            .hero-section {
                margin-bottom: 28px;
            }

            .hero-grid {
                display: grid;
                grid-template-columns: 1.6fr 1fr;
                gap: 2px;
                border: 1px solid var(--border);
                border-radius: 6px;
                overflow: hidden;
            }

            .hero-main {
                position: relative;
                background: #111;
                min-height: 360px;
                cursor: pointer;
            }

            .hero-img {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 80px;
                background: linear-gradient(135deg, #1a1a2e, #2d1a1a);
                opacity: .7;
            }

            .hero-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 20px 22px;
                background: linear-gradient(transparent, rgba(0, 0, 0, .85));
            }

            .hero-cat {
                display: inline-block;
                background: var(--red);
                color: #fff;
                font-size: 11px;
                font-weight: 700;
                padding: 3px 9px;
                border-radius: 3px;
                letter-spacing: 1px;
                text-transform: uppercase;
                margin-bottom: 8px;
            }

            .hero-title {
                font-family: 'Merriweather', serif;
                font-size: 22px;
                font-weight: 700;
                color: #fff;
                line-height: 1.35;
                margin-bottom: 6px;
            }

            .hero-meta {
                font-size: 12px;
                color: rgba(255, 255, 255, .6);
            }

            .hero-side {
                display: flex;
                flex-direction: column;
                gap: 2px;
            }

            .hero-thumb {
                position: relative;
                background: #222;
                flex: 1;
                cursor: pointer;
                min-height: 118px;
                display: flex;
                align-items: flex-end;
                overflow: hidden;
            }

            .hero-thumb:hover .ht-title {
                color: #ffd;
            }

            .ht-img {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 40px;
                opacity: .5;
            }

            .ht-overlay {
                position: relative;
                padding: 10px 14px;
                background: linear-gradient(transparent, rgba(0, 0, 0, .8));
                width: 100%;
            }

            .ht-cat {
                display: inline-block;
                background: var(--red);
                color: #fff;
                font-size: 10px;
                font-weight: 700;
                padding: 2px 6px;
                border-radius: 2px;
                margin-bottom: 4px;
                text-transform: uppercase;
            }

            .ht-title {
                font-family: 'Merriweather', serif;
                font-size: 13px;
                font-weight: 700;
                color: #fff;
                line-height: 1.35;
                transition: .15s;
            }

            /* ── SECTION HEADER ── */
            .sec-head {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 16px;
            }

            .sec-bar {
                width: 4px;
                height: 22px;
                background: var(--red);
                border-radius: 2px;
                flex-shrink: 0;
            }

            .sec-title {
                font-family: 'Merriweather', serif;
                font-size: 17px;
                font-weight: 900;
            }

            .sec-link {
                margin-left: auto;
                font-size: 12px;
                color: var(--red);
                font-weight: 600;
                cursor: pointer;
            }

            .sec-link:hover {
                text-decoration: underline;
            }

            .sec-divider {
                border: none;
                border-top: 2px solid var(--text);
                margin-bottom: 16px;
            }

            /* ── NEWS CARDS ── */
            .news-grid-3 {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 16px;
                margin-bottom: 28px;
            }

            .news-grid-2 {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
                margin-bottom: 28px;
            }

            .news-card {
                cursor: pointer;
                transition: .2s;
            }

            .news-card:hover .nc-title {
                color: var(--red);
            }

            .nc-img {
                width: 100%;
                aspect-ratio: 16/9;
                border-radius: 5px;
                background: var(--bg);
                border: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 32px;
                margin-bottom: 10px;
                overflow: hidden;
                transition: .2s;
            }

            .news-card:hover .nc-img {
                opacity: .85;
            }

            .nc-cat {
                display: inline-block;
                font-size: 10px;
                font-weight: 700;
                color: var(--red);
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 5px;
            }

            .nc-title {
                font-family: 'Merriweather', serif;
                font-size: 14px;
                font-weight: 700;
                line-height: 1.45;
                margin-bottom: 5px;
                transition: .15s;
            }

            .nc-meta {
                font-size: 11px;
                color: var(--muted);
                display: flex;
                gap: 8px;
                align-items: center;
            }

            /* ── LIST BERITA ── */
            .news-list-item {
                display: flex;
                gap: 12px;
                padding: 12px 0;
                border-bottom: 1px solid var(--border);
                cursor: pointer;
            }

            .news-list-item:last-child {
                border-bottom: none;
            }

            .news-list-item:hover .nli-title {
                color: var(--red);
            }

            .nli-img {
                width: 80px;
                height: 58px;
                border-radius: 4px;
                background: var(--bg);
                border: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                flex-shrink: 0;
            }

            .nli-cat {
                font-size: 10px;
                font-weight: 700;
                color: var(--red);
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 3px;
            }

            .nli-title {
                font-family: 'Merriweather', serif;
                font-size: 13px;
                font-weight: 700;
                line-height: 1.4;
                margin-bottom: 4px;
                transition: .15s;
            }

            .nli-meta {
                font-size: 11px;
                color: var(--muted);
            }

            /* ── SIDEBAR WIDGETS ── */
            .widget {
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: 6px;
                padding: 16px;
                margin-bottom: 20px;
            }

            .wgt-title {
                font-family: 'Merriweather', serif;
                font-size: 14px;
                font-weight: 900;
                margin-bottom: 12px;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--text);
            }

            .trending-item {
                display: flex;
                gap: 10px;
                padding: 9px 0;
                border-bottom: 1px solid var(--border);
                cursor: pointer;
            }

            .trending-item:last-child {
                border-bottom: none;
            }

            .trending-item:hover .tr-title {
                color: var(--red);
            }

            .tr-rank {
                font-family: 'JetBrains Mono';
                font-size: 16px;
                font-weight: 700;
                color: var(--red);
                width: 24px;
                flex-shrink: 0;
                line-height: 1;
            }

            .tr-rank.gold {
                color: #b8860b;
            }

            .tr-rank.silver {
                color: #888;
            }

            .tr-rank.bronze {
                color: #a0522d;
            }

            .tr-title {
                font-family: 'Merriweather', serif;
                font-size: 12.5px;
                font-weight: 700;
                line-height: 1.4;
                transition: .15s;
            }

            .tr-views {
                font-size: 10px;
                color: var(--muted);
                margin-top: 3px;
                display: flex;
                align-items: center;
                gap: 3px;
            }

            .tr-badge {
                font-size: 9px;
                font-weight: 700;
                padding: 1px 5px;
                border-radius: 3px;
                margin-left: 5px;
            }

            .tr-badge.up {
                background: #e8f8e8;
                color: #1a7a3c;
            }

            .tr-badge.hot {
                background: #ffe8e8;
                color: var(--red);
            }

            /* ── AD BANNER ── */
            .ad-banner {
                background: var(--text);
                color: var(--white);
                border-radius: 4px;
                padding: 14px;
                text-align: center;
                margin-bottom: 20px;
            }

            .ad-label {
                font-size: 10px;
                letter-spacing: 2px;
                opacity: .4;
                text-transform: uppercase;
                margin-bottom: 4px;
            }

            .ad-content {
                font-family: 'Merriweather', serif;
                font-size: 18px;
                font-weight: 900;
                letter-spacing: 2px;
            }

            /* ── EMPTY STATE ── */
            .empty-state {
                text-align: center;
                padding: 60px 20px;
            }

            .empty-state .es-icon {
                font-size: 48px;
                margin-bottom: 12px;
            }

            .empty-state .es-title {
                font-family: 'Merriweather', serif;
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 8px;
            }

            .empty-state .es-sub {
                font-size: 14px;
                color: var(--muted);
            }

            /* ── PAGE TITLE (for category view) ── */
            .page-header {
                padding: 20px 0 16px;
            }

            .ph-breadcrumb {
                font-size: 12px;
                color: var(--muted);
                margin-bottom: 8px;
            }

            .ph-breadcrumb span {
                color: var(--red);
            }

            .ph-title {
                font-family: 'Merriweather', serif;
                font-size: 26px;
                font-weight: 900;
                margin-bottom: 4px;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .ph-count {
                font-size: 13px;
                color: var(--muted);
                font-family: 'Source Sans 3', sans-serif;
                font-weight: 400;
            }

            .ph-divider {
                border: none;
                border-top: 3px solid var(--text);
                margin-bottom: 24px;
            }

            /* ── ARTICLE ── */
            .article-cat {
                font-size: 11px;
                font-weight: 700;
                color: var(--red);
                text-transform: uppercase;
                letter-spacing: 1.5px;
                margin-bottom: 10px;
            }

            .article-title {
                font-family: 'Merriweather', serif;
                font-size: 28px;
                font-weight: 900;
                line-height: 1.3;
                margin-bottom: 12px;
            }

            .article-byline {
                display: flex;
                align-items: center;
                gap: 16px;
                padding: 12px 0;
                border-top: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
                margin-bottom: 20px;
            }

            .a-avatar {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background: var(--red);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 14px;
                flex-shrink: 0;
            }

            .a-author {
                font-weight: 600;
                font-size: 13px;
            }

            .a-date {
                font-size: 12px;
                color: var(--muted);
            }

            .a-stats {
                margin-left: auto;
                display: flex;
                gap: 14px;
                font-size: 12px;
                color: var(--muted);
            }

            .a-stat {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .article-hero {
                width: 100%;
                aspect-ratio: 16/9;
                border-radius: 8px;
                background: linear-gradient(135deg, #2d1a1a, #1a2d1a);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 80px;
                margin-bottom: 20px;
                border: 1px solid var(--border);
            }

            .article-body {
                font-size: 16px;
                line-height: 1.8;
                color: #2a2a2a;
            }

            .article-body p {
                margin-bottom: 16px;
            }

            .article-body h2 {
                font-family: 'Merriweather', serif;
                font-size: 20px;
                font-weight: 700;
                margin: 24px 0 12px;
            }

            .article-body blockquote {
                border-left: 4px solid var(--red);
                padding: 10px 16px;
                background: #fde8e826;
                border-radius: 0 6px 6px 0;
                margin: 16px 0;
                font-style: italic;
                color: var(--muted);
            }

            /* ── REACTION BAR ── */
            .reaction-bar {
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: 8px;
                padding: 16px 20px;
                margin: 24px 0;
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
            }

            .rb-label {
                font-size: 13px;
                color: var(--muted);
                margin-right: 4px;
            }

            .reaction-btn {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 8px 14px;
                border-radius: 30px;
                border: 1.5px solid var(--border);
                background: var(--bg);
                cursor: pointer;
                transition: all .15s;
                font-size: 14px;
            }

            .reaction-btn:hover,
            .reaction-btn.active {
                border-color: var(--red);
                background: #fde8e826;
            }

            .reaction-btn.active .rb-count {
                color: var(--red);
                font-weight: 700;
            }

            .rb-count {
                font-size: 12px;
                color: var(--muted);
                font-family: 'JetBrains Mono';
            }

            /* ── SHARE BAR ── */
            .share-bar {
                display: flex;
                align-items: center;
                gap: 8px;
                margin: 16px 0;
                padding: 14px 0;
                border-top: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
                flex-wrap: wrap;
            }

            .share-label {
                font-size: 13px;
                font-weight: 600;
                margin-right: 4px;
            }

            .share-btn {
                padding: 7px 14px;
                border-radius: 4px;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                border: none;
                transition: .15s;
                font-family: inherit;
            }

            .sb-fb {
                background: #1877f2;
                color: #fff;
            }

            .sb-tw {
                background: #000;
                color: #fff;
            }

            .sb-wa {
                background: #25d366;
                color: #fff;
            }

            .sb-copy {
                background: var(--bg);
                border: 1px solid var(--border) !important;
                border: none;
                color: var(--text);
            }

            .sb-copy:hover {
                border-color: var(--red);
            }

            .share-btn:hover {
                opacity: .85;
            }

            /* ── COMMENTS ── */
            .comments-section {
                margin-top: 28px;
            }

            .cs-title {
                font-family: 'Merriweather', serif;
                font-size: 18px;
                font-weight: 900;
                margin-bottom: 16px;
                padding-bottom: 12px;
                border-bottom: 2px solid var(--text);
            }

            .comment-form {
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: 8px;
                padding: 16px;
                margin-bottom: 20px;
            }

            .cf-input {
                width: 100%;
                border: 1.5px solid var(--border);
                border-radius: 6px;
                padding: 11px 13px;
                font-family: inherit;
                font-size: 14px;
                resize: none;
                outline: none;
                transition: .15s;
                min-height: 80px;
            }

            .cf-input:focus {
                border-color: var(--red);
            }

            .cf-foot {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: 10px;
            }

            .cf-name {
                border: 1.5px solid var(--border);
                border-radius: 6px;
                padding: 8px 12px;
                font-family: inherit;
                font-size: 13px;
                outline: none;
                width: 200px;
                transition: .15s;
            }

            .cf-name:focus {
                border-color: var(--red);
            }

            .cf-submit {
                background: var(--red);
                color: #fff;
                border: none;
                border-radius: 6px;
                padding: 9px 18px;
                font-size: 13px;
                font-weight: 700;
                cursor: pointer;
                font-family: inherit;
                transition: .15s;
            }

            .cf-submit:hover {
                background: var(--red-dark);
            }

            .comment-item {
                display: flex;
                gap: 12px;
                margin-bottom: 16px;
            }

            .ci-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: var(--bg);
                border: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 13px;
                flex-shrink: 0;
                color: var(--muted);
            }

            .ci-body {
                flex: 1;
            }

            .ci-user {
                font-weight: 700;
                font-size: 13px;
                margin-bottom: 2px;
            }

            .ci-time {
                font-size: 11px;
                color: var(--muted);
                margin-bottom: 6px;
            }

            .ci-text {
                font-size: 14px;
                line-height: 1.6;
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: 6px;
                padding: 10px 13px;
            }

            .ci-acts {
                display: flex;
                gap: 10px;
                margin-top: 7px;
                font-size: 12px;
                color: var(--muted);
            }

            .ci-act {
                cursor: pointer;
                transition: .15s;
            }

            .ci-act:hover {
                color: var(--red);
            }

            /* ── VIEW COUNTER ── */
            .view-counter {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: var(--bg);
                border: 1px solid var(--border);
                border-radius: 20px;
                padding: 3px 10px;
                font-size: 12px;
                font-family: 'JetBrains Mono';
            }

            .vc-pulse {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--red);
                animation: vcPulse 2s infinite;
            }

            @keyframes vcPulse {

                0%,
                100% {
                    opacity: 1
                }

                50% {
                    opacity: .3
                }
            }

            /* ── SEARCH RESULTS PAGE ── */
            .search-results-page {
                display: none;
            }

            .search-results-page.active {
                display: block;
            }

            .sr-head {
                margin-bottom: 20px;
            }

            .sr-title {
                font-family: 'Merriweather', serif;
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 4px;
            }

            .sr-sub {
                font-size: 14px;
                color: var(--muted);
            }

            .sr-filters {
                display: flex;
                gap: 8px;
                margin-top: 12px;
                flex-wrap: wrap;
            }

            .sr-filter-chip {
                padding: 4px 12px;
                border-radius: 20px;
                border: 1.5px solid var(--border);
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                transition: .15s;
                background: var(--bg);
            }

            .sr-filter-chip:hover {
                border-color: var(--red);
                color: var(--red);
            }

            .sr-filter-chip.active {
                background: var(--red);
                border-color: var(--red);
                color: #fff;
            }

            /* ── TOAST NOTIFICATION ── */
            .toast {
                position: fixed;
                bottom: 24px;
                right: 24px;
                background: var(--text);
                color: #fff;
                padding: 12px 20px;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                z-index: 9999;
                display: none;
                box-shadow: 0 4px 16px rgba(0, 0, 0, .2);
                animation: toastIn .3s ease;
            }

            .toast.show {
                display: block;
            }

            @keyframes toastIn {
                from {
                    opacity: 0;
                    transform: translateY(12px)
                }

                to {
                    opacity: 1;
                    transform: translateY(0)
                }
            }

            /* ── FOOTER ── */
            .footer {
                background: var(--text);
                color: #fff;
                margin-top: 40px;
            }

            .footer-inner {
                max-width: 1180px;
                margin: 0 auto;
                padding: 36px 20px;
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr;
                gap: 32px;
            }

            .ft-brand {
                font-family: 'Merriweather', serif;
                font-size: 28px;
                font-weight: 900;
                color: var(--red);
                margin-bottom: 8px;
            }

            .ft-desc {
                font-size: 13px;
                color: #aaa;
                line-height: 1.6;
            }

            .ft-col-title {
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: #aaa;
                margin-bottom: 12px;
            }

            .ft-link {
                font-size: 13px;
                color: #ccc;
                margin-bottom: 8px;
                cursor: pointer;
                transition: .15s;
                display: block;
            }

            .ft-link:hover {
                color: var(--white);
            }

            .footer-bottom {
                border-top: 1px solid #2a2a2a;
                padding: 14px 20px;
                text-align: center;
                font-size: 12px;
                color: #555;
            }

            /* Cat colors */
            .cat-politik {
                color: #cc0000;
            }

            .cat-ekonomi {
                color: #1a3a7a;
            }

            .cat-olahraga {
                color: #1a7a3c;
            }

            .cat-teknologi {
                color: #7a1a7a;
            }

            .cat-kesehatan {
                color: #b86200;
            }

            .cat-hukum {
                color: #555;
            }

            .cat-lingkungan {
                color: #2a6a2a;
            }

            .cat-budaya {
                color: #8b5e00;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(10px)
                }

                to {
                    opacity: 1;
                    transform: translateY(0)
                }
            }

            .page-anim {
                animation: slideIn .25s ease;
            }

            /* LOADING SKELETON */
            .skeleton {
                background: linear-gradient(90deg, var(--border) 25%, #e8e4dc 50%, var(--border) 75%);
                background-size: 200% 100%;
                animation: shimmer 1.5s infinite;
                border-radius: 4px;
            }

            @keyframes shimmer {
                0% {
                    background-position: 200% 0
                }

                100% {
                    background-position: -200% 0
                }
            }
        </style>
    </head>

    <body>

        <!-- TOAST -->
        <div class="toast" id="toast"></div>

        <!-- ═══════════════════════════════════════════════════════ -->
        <!-- HOME VIEW -->
        <!-- ═══════════════════════════════════════════════════════ -->
        <div id="homeView" style="display:block;">
            <div class="container page-anim">

                <!-- SEARCH RESULTS INLINE -->
                <div class="search-results-page" id="searchResultsPage">
                    <div class="sr-head">
                        <div class="sr-title" id="srTitle">Hasil pencarian</div>
                        <div class="sr-sub" id="srSub"></div>
                        <div class="sr-filters" id="srFilters"></div>
                    </div>
                    <div id="srContent"></div>
                    <hr style="margin:20px 0 24px; border:none; border-top:1px solid var(--border);">
                </div>

                <!-- CATEGORY PAGE HEADER (shown when filtering) -->
                <div id="catPageHeader" style="display:none;">
                    <div class="page-header">
                        <div class="ph-breadcrumb">HOME › <span id="catBreadcrumb">KATEGORI</span></div>
                        <div class="ph-title"><span id="catIcon">📰</span><span id="catLabel">Kategori</span> <small
                                class="ph-count" id="catCount"></small></div>
                    </div>
                    <hr class="ph-divider">
                </div>

                <!-- HERO SECTION (home only) -->
                <div class="hero-section" id="heroSection">
                    <div class="hero-grid">
                        <div class="hero-main" onclick="openArticle('berkas-epstein')">
                            <div class="hero-img">🕵️</div>
                            <div class="hero-overlay">
                                <div class="hero-cat">Pilihan Editor</div>
                                <div class="hero-title">Berkas Epstein memicu era baru teori konspirasi global</div>
                                <div class="hero-meta">Budi Santoso • 10 Mar 2026 &nbsp;·&nbsp; <span
                                        class="view-counter"><span class="vc-pulse"></span>84.2K views</span></div>
                            </div>
                        </div>
                        <div class="hero-side">
                            <div class="hero-thumb" onclick="openArticle('komisi-x')">
                                <div class="ht-img">🏛️</div>
                                <div class="ht-overlay">
                                    <div class="ht-cat">Politik</div>
                                    <div class="ht-title">Komisi X DPR: "LPDP Dana Publik, Bukan Hak Segelintir Elite"
                                    </div>
                                </div>
                            </div>
                            <div class="hero-thumb" onclick="openArticle('gajah-sumatera')">
                                <div class="ht-img" style="background:linear-gradient(#1a2a1a,#0a1a0a)">🐘</div>
                                <div class="ht-overlay">
                                    <div class="ht-cat">Lingkungan</div>
                                    <div class="ht-title">Gajah Sumatera Mati Terlilit Kawat Listrik di Aceh</div>
                                </div>
                            </div>
                            <div class="hero-thumb" onclick="openArticle('seskab-teddy')">
                                <div class="ht-img" style="background:linear-gradient(#2a1a2a,#1a0a2a)">👔</div>
                                <div class="ht-overlay">
                                    <div class="ht-cat">Politik</div>
                                    <div class="ht-title">Seskab Teddy: Produk AS Tetap Wajib Sertifikasi Halal</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAIN CONTENT GRID -->
                <div class="main-grid">
                    <div>
                        <!-- SECTION: BERITA TERKINI -->
                        <div id="sectionTerkini">
                            <div class="sec-head">
                                <div class="sec-bar"></div>
                                <div class="sec-title" id="mainSectionTitle">Berita Terkini</div>
                                <div class="sec-link" onclick="setNav(null,'terkini')">Lihat Semua →</div>
                            </div>
                            <hr class="sec-divider">
                            <div class="news-grid-3" id="mainGrid"></div>
                        </div>

                        <!-- AD BANNER -->
                        <div class="ad-banner" id="adBanner">
                            <div class="ad-label">Advertisement</div>
                            <div class="ad-content">RICHARD MILLE</div>
                        </div>

                        <!-- SECTION: BERITA POPULER -->
                        <div id="sectionPopuler">
                            <div class="sec-head">
                                <div class="sec-bar" style="background:#1a3a7a"></div>
                                <div class="sec-title">Berita Populer & Trending</div>
                                <div class="sec-link" onclick="filterTopStrip('populer',null)">Lihat Semua →</div>
                            </div>
                            <hr class="sec-divider">
                            <div class="news-grid-3" id="popularGrid" style="margin-bottom:0"></div>
                        </div>

                        <!-- SECTION: BERITA TERBARU (list) -->
                        <div style="margin-top:28px;" id="sectionTerbaru">
                            <div class="sec-head">
                                <div class="sec-bar" style="background:#1a7a3c"></div>
                                <div class="sec-title">Berita Terbaru</div>
                            </div>
                            <hr class="sec-divider">
                            <div id="newsList"></div>
                        </div>
                    </div>

                    <!-- SIDEBAR -->
                    <div>
                        <!-- TRENDING WIDGET (dynamic) -->
                        <div class="widget">
                            <div class="wgt-title">🔥 Trending Sekarang</div>
                            <div id="trendingWidget"></div>
                        </div>

                        <!-- AD -->
                        <div class="ad-banner" style="margin-bottom:20px;">
                            <div class="ad-label">Advertisement</div>
                            <div class="ad-content" style="font-size:14px;">IKLAN ANDA DI SINI</div>
                            <div style="font-size:11px;opacity:.5;margin-top:4px;">300×250</div>
                        </div>

                        <!-- PILIHAN EDITOR -->
                        <div class="widget">
                            <div class="wgt-title">✨ Pilihan Editor</div>
                            <div id="editorPicks"></div>
                        </div>

                        <!-- KATEGORI WIDGET -->
                        <div class="widget">
                            <div class="wgt-title">📂 Jelajahi Kategori</div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;" id="categoryWidget"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════ -->
        <!-- ARTICLE VIEW -->
        <!-- ═══════════════════════════════════════════════════════ -->
        <div id="articleView" style="display:none;">
            <div class="container page-anim">
                <div style="margin-bottom:16px;">
                    <button onclick="goBack()"
                        style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:7px 14px;cursor:pointer;font-family:inherit;font-size:13px;display:flex;align-items:center;gap:6px;">←
                        Kembali</button>
                </div>
                <div class="main-grid">
                    <div>
                        <div class="article-cat" id="artCat">Kategori</div>
                        <h1 class="article-title" id="artTitle">Judul</h1>
                        <div class="article-byline">
                            <div class="a-avatar" id="artAvatar">A</div>
                            <div>
                                <div class="a-author" id="artAuthor">Penulis</div>
                                <div class="a-date" id="artDate">10 Maret 2026, 09:41 WIB</div>
                            </div>
                            <div class="a-stats">
                                <div class="a-stat">
                                    <div class="view-counter"><span class="vc-pulse"></span><span id="viewCount">0</span>
                                        views</div>
                                </div>
                                <div class="a-stat">💬 <span id="cmtCount">0</span> komentar</div>
                            </div>
                        </div>
                        <div class="article-hero" id="artHero">📰</div>
                        <div class="article-body" id="artBody"></div>

                        <!-- SHARE BAR -->
                        <div class="share-bar">
                            <span class="share-label">Bagikan:</span>
                            <button class="share-btn sb-fb" onclick="share('facebook')">Facebook</button>
                            <button class="share-btn sb-tw" onclick="share('twitter')">X (Twitter)</button>
                            <button class="share-btn sb-wa" onclick="share('whatsapp')">WhatsApp</button>
                            <button class="share-btn sb-copy" onclick="copyLink()">📋 Salin Link</button>
                        </div>

                        <!-- REACTION BAR -->
                        <div class="reaction-bar">
                            <span class="rb-label">Reaksi Anda:</span>
                            <div class="reaction-btn active" id="rb-like" onclick="react('like')">👍 <span
                                    class="rb-count" id="rc-like">248</span></div>
                            <div class="reaction-btn" id="rb-love" onclick="react('love')">❤️ <span class="rb-count"
                                    id="rc-love">87</span></div>
                            <div class="reaction-btn" id="rb-wow" onclick="react('wow')">😮 <span class="rb-count"
                                    id="rc-wow">32</span></div>
                            <div class="reaction-btn" id="rb-sad" onclick="react('sad')">😢 <span class="rb-count"
                                    id="rc-sad">14</span></div>
                            <div class="reaction-btn" id="rb-angry" onclick="react('angry')">😡 <span class="rb-count"
                                    id="rc-angry">9</span></div>
                        </div>

                        <!-- COMMENTS -->
                        <div class="comments-section">
                            <div class="cs-title">Komentar (<span id="totalCmt">3</span>)</div>
                            <div class="comment-form">
                                <textarea class="cf-input" id="cmtInput" placeholder="Tulis komentar Anda..."></textarea>
                                <div class="cf-foot">
                                    <input class="cf-name" id="cmtName" type="text"
                                        placeholder="Nama Anda (opsional)">
                                    <button class="cf-submit" onclick="submitComment()">Kirim Komentar</button>
                                </div>
                            </div>
                            <div id="commentsList">
                                <div class="comment-item">
                                    <div class="ci-avatar" style="background:#e8f4e8;color:#1a7a3c;">R</div>
                                    <div class="ci-body">
                                        <div class="ci-user">Rudi Hermawan</div>
                                        <div class="ci-time">2 jam lalu</div>
                                        <div class="ci-text">Informasi yang sangat bermanfaat. Terima kasih FNM!</div>
                                        <div class="ci-acts"><span class="ci-act" onclick="likeComment(this)">👍 Suka
                                                (12)</span><span class="ci-act">↩ Balas</span></div>
                                    </div>
                                </div>
                                <div class="comment-item">
                                    <div class="ci-avatar" style="background:#e8e8f4;color:#1a1a7a;">S</div>
                                    <div class="ci-body">
                                        <div class="ci-user">Siti Nurhaliza</div>
                                        <div class="ci-time">4 jam lalu</div>
                                        <div class="ci-text">Penting banget nih beritanya. Semoga bisa ditindaklanjuti!
                                        </div>
                                        <div class="ci-acts"><span class="ci-act" onclick="likeComment(this)">👍 Suka
                                                (8)</span><span class="ci-act">↩ Balas</span></div>
                                    </div>
                                </div>
                                <div class="comment-item">
                                    <div class="ci-avatar">A</div>
                                    <div class="ci-body">
                                        <div class="ci-user">Anonim</div>
                                        <div class="ci-time">6 jam lalu</div>
                                        <div class="ci-text">Sudah waktunya ada perubahan nyata, bukan sekadar wacana.
                                        </div>
                                        <div class="ci-acts"><span class="ci-act" onclick="likeComment(this)">👍 Suka
                                                (5)</span><span class="ci-act">↩ Balas</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ARTICLE SIDEBAR -->
                    <div>
                        <div class="widget">
                            <div class="wgt-title">📰 Berita Terkait</div>
                            <div id="relatedArticles"></div>
                        </div>
                        <div class="ad-banner">
                            <div class="ad-label">Advertisement</div>
                            <div class="ad-content" style="font-size:13px;">IKLAN ANDA DI SINI</div>
                        </div>
                        <div class="widget">
                            <div class="wgt-title">🔥 Trending</div>
                            <div id="artSidebarTrending"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ FOOTER ═══ -->
        <div class="footer">
            <div class="footer-inner">
                <div>
                    <div class="ft-brand">FNM</div>
                    <div class="ft-desc">Fenomena News Media — Delivering unbiased, in-depth reporting on the stories that
                        shape our world.</div>
                </div>
                <div>
                    <div class="ft-col-title">Kategori</div>
                    <a class="ft-link" onclick="setNav(null,'politik')">Politik</a>
                    <a class="ft-link" onclick="setNav(null,'ekonomi')">Ekonomi</a>
                    <a class="ft-link" onclick="setNav(null,'teknologi')">Teknologi</a>
                    <a class="ft-link" onclick="setNav(null,'olahraga')">Olahraga</a>
                </div>
                <div>
                    <div class="ft-col-title">Legal</div>
                    <a class="ft-link">Privacy Policy</a>
                    <a class="ft-link">Terms of Service</a>
                    <a class="ft-link">Editorial Policy</a>
                    <a class="ft-link">Contact Us</a>
                </div>
                <div>
                    <div class="ft-col-title">Ikuti Kami</div>
                    <a class="ft-link" onclick="openSocial('facebook')">Facebook</a>
                    <a class="ft-link" onclick="openSocial('instagram')">Instagram</a>
                    <a class="ft-link" onclick="openSocial('twitter')">Twitter / X</a>
                    <a class="ft-link" onclick="openSocial('whatsapp')">WhatsApp</a>
                </div>
            </div>
            <div class="footer-bottom">© 2026 Fenomena News Media. All rights reserved.</div>
        </div>
    @endsection
    @section('js')
        <script>
            // ═══════════════════════════════════════════════════
            // DATA LAYER — Loaded from API
            // ═══════════════════════════════════════════════════
            let articles = {};
            let categories = [];

            // Load data from API
            async function loadArticles(filter = '') {
                try {
                    const url = filter ? `/api/viewers/berita?filter=${filter}` : '/api/viewers/berita';
                    const response = await fetch(url);
                    const data = await response.json();
                    data.data.forEach(article => {
                        articles[article.slug] = {
                            cat: article.kategori ? article.kategori.nama_kategori : 'Umum',
                            category: article.kategori ? article.kategori.slug : 'umum',
                            type: filter === 'populer' ? 'populer' : (filter === 'editor' ? 'editor' : 'terkini'),
                            title: article.judul_berita,
                            author: article.user ? article.user.name : 'Anonim',
                            avatar: article.user ? article.user.name[0].toUpperCase() : 'A',
                            hero: '📰', // Default icon, bisa diganti berdasarkan kategori
                            views: article.jumlah_view,
                            cmt: 0, // Belum ada komentar di API
                            date: new Date(article.created_at).toLocaleDateString('id-ID'),
                            tags: [article.kategori ? article.kategori.slug : 'umum'],
                            body: article.isi_berita
                        };
                    });
                    // After loading, render the page
                    showHomeView();
                } catch (error) {
                    console.error('Error loading articles:', error);
                }
            }

            async function loadCategories() {
                try {
                    const response = await fetch('/api/viewers/kategori');
                    categories = await response.json();
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
            }

            // Load data on page load
            window.addEventListener('DOMContentLoaded', async () => {
                await loadCategories();
                await loadArticles();
            });

            // ═══════════════════════════════════════════════════
            // STATE MANAGEMENT
            // ═══════════════════════════════════════════════════
            const state = {
                currentView: 'home', // 'home' | 'category' | 'article' | 'search'
                currentCat: 'home',
                currentTopFilter: 'terkini',
                currentArticle: null,
                viewCounts: {},
                reactions: {},
                searchQuery: '',
                history: [], // navigation stack
            };

            // Category metadata
            const catMeta = {
                home: {
                    label: 'Beranda',
                    icon: '🏠',
                    color: '#cc0000'
                },
                terkini: {
                    label: 'Terkini',
                    icon: '⚡',
                    color: '#cc0000'
                },
                politik: {
                    label: 'Politik',
                    icon: '🏛️',
                    color: '#cc0000'
                },
                ekonomi: {
                    label: 'Ekonomi',
                    icon: '💹',
                    color: '#1a3a7a'
                },
                olahraga: {
                    label: 'Olahraga',
                    icon: '⚽',
                    color: '#1a7a3c'
                },
                teknologi: {
                    label: 'Teknologi',
                    icon: '💻',
                    color: '#7a1a7a'
                },
                kesehatan: {
                    label: 'Kesehatan',
                    icon: '🩺',
                    color: '#b86200'
                },
                hukum: {
                    label: 'Hukum',
                    icon: '⚖️',
                    color: '#555'
                },
                lingkungan: {
                    label: 'Lingkungan',
                    icon: '🌿',
                    color: '#2a6a2a'
                },
                budaya: {
                    label: 'Budaya',
                    icon: '🎭',
                    color: '#8b5e00'
                },
                pendidikan: {
                    label: 'Pendidikan',
                    icon: '🎓',
                    color: '#cc0000'
                },
                bencana: {
                    label: 'Bencana',
                    icon: '🌊',
                    color: '#555'
                },
            };

            // ── Utilities ──
            function fmtNum(n) {
                const num = typeof n === 'string' ? parseFloat(n) : n;
                if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
                if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
                return num.toFixed ? num.toFixed(0) : String(num);
            }

            function getViews(slug) {
                if (!state.viewCounts[slug]) {
                    const base = articles[slug]?.views || 0;
                    state.viewCounts[slug] = typeof base === 'string' ?
                        parseFloat(base) * 1000 : base;
                }
                return state.viewCounts[slug];
            }

            function incrementView(slug) {
                state.viewCounts[slug] = getViews(slug) + 1;
                return state.viewCounts[slug];
            }

            function showToast(msg, duration = 2500) {
                const t = document.getElementById('toast');
                t.textContent = msg;
                t.classList.add('show');
                setTimeout(() => t.classList.remove('show'), duration);
            }

            function getCatColor(category) {
                return catMeta[category]?.color || 'var(--red)';
            }

            // ═══════════════════════════════════════════════════
            // NAVIGATION & ROUTING
            // ═══════════════════════════════════════════════════
            function setNav(el, cat) {
                // Sync nav item active state
                document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
                if (el) {
                    el.classList.add('active');
                } else {
                    // find by data-cat
                    const found = document.querySelector(`.nav-item[data-cat="${cat}"]`);
                    if (found) found.classList.add('active');
                }

                // Close more dropdown
                closeNavMore();

                state.currentCat = cat;
                state.history.push({
                    view: 'home',
                    cat
                });

                // Reset topstrip to terkini when navigating
                if (cat === 'home') {
                    filterTopStrip('terkini', document.getElementById('ts-terkini'));
                    showHomeView();
                } else {
                    showCategoryView(cat);
                }

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function showHomeView() {
                document.getElementById('heroSection').style.display = 'block';
                document.getElementById('sectionTerkini').style.display = 'block';
                document.getElementById('sectionPopuler').style.display = 'block';
                document.getElementById('sectionTerbaru').style.display = 'block';
                document.getElementById('adBanner').style.display = 'block';
                document.getElementById('catPageHeader').style.display = 'none';
                document.getElementById('searchResultsPage').classList.remove('active');

                renderMainGrid(getSortedArticles('terkini'));
                renderPopularGrid();
                renderNewsList(Object.entries(articles));
                renderTrendingWidget();
                renderEditorPicks();
                renderCategoryWidget();
            }

            function showCategoryView(cat) {
                const filtered = Object.entries(articles).filter(([k, v]) => v.category === cat);
                const meta = catMeta[cat] || {
                    label: cat,
                    icon: '📰'
                };

                document.getElementById('heroSection').style.display = 'none';
                document.getElementById('adBanner').style.display = 'block';
                document.getElementById('searchResultsPage').classList.remove('active');

                // Show category header
                document.getElementById('catPageHeader').style.display = 'block';
                document.getElementById('catBreadcrumb').textContent = meta.label.toUpperCase();
                document.getElementById('catIcon').textContent = meta.icon;
                document.getElementById('catLabel').textContent = meta.label;
                document.getElementById('catCount').textContent = `${filtered.length} artikel`;

                // Show section with filtered articles
                document.getElementById('sectionTerkini').style.display = 'block';
                document.getElementById('mainSectionTitle').textContent = `Berita ${meta.label}`;
                renderMainGrid(filtered);

                // Show populer in same cat
                document.getElementById('sectionPopuler').style.display = filtered.length > 3 ? 'none' : 'none';
                document.getElementById('sectionTerbaru').style.display = 'block';
                renderNewsList(filtered);

                renderTrendingWidget();
                renderEditorPicks();
                renderCategoryWidget();
            }

            // ═══════════════════════════════════════════════════
            // TOP STRIP FILTER
            // ═══════════════════════════════════════════════════
            function filterTopStrip(type, el) {
                // Update active state on topstrip
                document.querySelectorAll('.ts-link').forEach(t => t.classList.remove('active'));
                const target = el || document.getElementById('ts-' + type);
                if (target) target.classList.add('active');

                state.currentTopFilter = type;

                // Reset nav to home
                document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
                document.querySelector('.nav-item[data-cat="home"]').classList.add('active');

                // Show home view layout
                document.getElementById('heroSection').style.display = type === 'terkini' ? 'block' : 'none';
                document.getElementById('catPageHeader').style.display = type !== 'terkini' ? 'block' : 'none';
                document.getElementById('searchResultsPage').classList.remove('active');
                document.getElementById('adBanner').style.display = 'block';

                const typeLabels = {
                    terkini: {
                        label: 'Berita Terkini',
                        icon: '⚡'
                    },
                    populer: {
                        label: 'Berita Populer',
                        icon: '🔥'
                    },
                    editor: {
                        label: 'Pilihan Editor',
                        icon: '✨'
                    },
                    artikel: {
                        label: 'Artikel',
                        icon: '📝'
                    },
                };
                const tl = typeLabels[type] || {
                    label: type,
                    icon: '📰'
                };

                if (type !== 'terkini') {
                    document.getElementById('catBreadcrumb').textContent = tl.label.toUpperCase();
                    document.getElementById('catIcon').textContent = tl.icon;
                    document.getElementById('catLabel').textContent = tl.label;
                }

                let filtered;
                if (type === 'terkini') {
                    filtered = getSortedArticles('terkini');
                } else {
                    filtered = Object.entries(articles).filter(([k, v]) => v.type === type);
                    if (!filtered.length) filtered = Object.entries(articles); // fallback
                }

                document.getElementById('catCount').textContent = `${filtered.length} artikel`;
                document.getElementById('mainSectionTitle').textContent = tl.label;
                document.getElementById('sectionTerkini').style.display = 'block';
                renderMainGrid(filtered);

                if (type === 'terkini') {
                    document.getElementById('sectionPopuler').style.display = 'block';
                    document.getElementById('sectionTerbaru').style.display = 'block';
                    renderPopularGrid();
                    renderNewsList(Object.entries(articles));
                } else {
                    document.getElementById('sectionPopuler').style.display = 'none';
                    document.getElementById('sectionTerbaru').style.display = 'block';
                    renderNewsList(filtered);
                }

                renderTrendingWidget();
                renderEditorPicks();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            // ═══════════════════════════════════════════════════
            // ARTICLE OPEN / CLOSE
            // ═══════════════════════════════════════════════════
            function openArticle(slug) {
                const a = articles[slug];
                if (!a) return;

                state.history.push({
                    view: 'article',
                    slug
                });
                state.currentArticle = slug;
                const vCount = incrementView(slug);

                // Fill article data
                document.getElementById('artCat').textContent = a.cat;
                document.getElementById('artTitle').textContent = a.title;
                document.getElementById('artAuthor').textContent = a.author;
                document.getElementById('artAvatar').textContent = a.avatar;
                document.getElementById('artHero').textContent = a.hero;
                document.getElementById('artDate').textContent = `${a.date || '10 Mar 2026'}, 09:41 WIB`;
                document.getElementById('viewCount').textContent = fmtNum(vCount);
                document.getElementById('cmtCount').textContent = a.cmt;
                document.getElementById('totalCmt').textContent = 3;
                document.getElementById('artBody').innerHTML = a.body || '<p>Konten artikel akan segera tersedia.</p>';

                // Reset reactions
                document.querySelectorAll('.reaction-btn').forEach(r => r.classList.remove('active'));
                document.getElementById('rb-like').classList.add('active');

                // Related articles (same category, exclude current)
                renderRelatedArticles(slug, a.category);
                renderArtSidebarTrending();

                // Switch views
                document.getElementById('homeView').style.display = 'none';
                document.getElementById('articleView').style.display = 'block';
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function goBack() {
                state.history.pop(); // remove current
                const prev = state.history[state.history.length - 1];

                document.getElementById('articleView').style.display = 'none';
                document.getElementById('homeView').style.display = 'block';

                if (prev && prev.view === 'home' && prev.cat && prev.cat !== 'home') {
                    showCategoryView(prev.cat);
                } else {
                    showHomeView();
                }
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function goHome() {
                state.history = [];
                state.currentCat = 'home';
                document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
                document.querySelector('.nav-item[data-cat="home"]').classList.add('active');
                document.querySelectorAll('.ts-link').forEach(t => t.classList.remove('active'));
                document.getElementById('ts-terkini').classList.add('active');
                document.getElementById('homeView').style.display = 'block';
                document.getElementById('articleView').style.display = 'none';
                closeSearchDropdown();
                showHomeView();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            // ═══════════════════════════════════════════════════
            // RENDER FUNCTIONS
            // ═══════════════════════════════════════════════════
            function getSortedArticles(sortType = 'terkini') {
                const all = Object.entries(articles);
                if (sortType === 'populer') return [...all].sort((a, b) => getViews(b[0]) - getViews(a[0]));
                if (sortType === 'terkini') return all; // already ordered by recency
                return all;
            }

            function renderMainGrid(list) {
                const container = document.getElementById('mainGrid');
                if (!list || !list.length) {
                    container.innerHTML = `<div class="empty-state" style="grid-column:1/-1">
      <div class="es-icon">📭</div>
      <div class="es-title">Tidak ada artikel</div>
      <div class="es-sub">Belum ada artikel di kategori ini</div>
    </div>`;
                    return;
                }
                container.innerHTML = list.slice(0, 6).map(([slug, v]) => `
    <div class="news-card" onclick="openArticle('${slug}')">
      <div class="nc-img">${v.hero}</div>
      <div class="nc-cat" style="color:${getCatColor(v.category)}">${v.cat}</div>
      <div class="nc-title">${v.title}</div>
      <div class="nc-meta">
        <span>${v.author}</span><span>·</span>
        <span class="nc-views">👁 ${fmtNum(getViews(slug))}</span>
      </div>
    </div>
  `).join('');
            }

            function renderPopularGrid() {
                const sorted = getSortedArticles('populer').slice(0, 3);
                const container = document.getElementById('popularGrid');
                container.innerHTML = sorted.map(([slug, v]) => `
    <div class="news-card" onclick="openArticle('${slug}')">
      <div class="nc-img">${v.hero}</div>
      <div class="nc-cat" style="color:${getCatColor(v.category)}">${v.cat}</div>
      <div class="nc-title">${v.title}</div>
      <div class="nc-meta">
        <span>${v.author}</span><span>·</span>
        <span class="nc-views">🔥 ${fmtNum(getViews(slug))}</span>
      </div>
    </div>
  `).join('');
            }

            function renderNewsList(list) {
                const container = document.getElementById('newsList');
                const items = list.slice(0, 6);
                container.innerHTML = items.map(([slug, v]) => `
    <div class="news-list-item" onclick="openArticle('${slug}')">
      <div class="nli-img">${v.hero}</div>
      <div>
        <div class="nli-cat" style="color:${getCatColor(v.category)}">${v.cat}</div>
        <div class="nli-title">${v.title}</div>
        <div class="nli-meta">${v.author} • ${v.date || '10 Mar 2026'} · 👁 ${fmtNum(getViews(slug))} views</div>
      </div>
    </div>
  `).join('');
            }

            function renderTrendingWidget() {
                // Dynamic: sort all articles by view count
                const sorted = Object.entries(articles)
                    .sort((a, b) => getViews(b[0]) - getViews(a[0]))
                    .slice(0, 5);

                const rankColors = ['gold', 'silver', 'bronze', '', ''];
                const badges = [
                    '<span class="tr-badge hot">🔥 Hot</span>',
                    '<span class="tr-badge up">▲ Naik</span>',
                    '', '', ''
                ];

                document.getElementById('trendingWidget').innerHTML = sorted.map(([slug, v], i) => `
    <div class="trending-item" onclick="openArticle('${slug}')">
      <div class="tr-rank ${rankColors[i]}">${String(i+1).padStart(2,'0')}</div>
      <div>
        <div class="tr-title">${v.title}${badges[i]}</div>
        <div class="tr-views">👁 ${fmtNum(getViews(slug))} views · ${v.cat}</div>
      </div>
    </div>
  `).join('');
            }

            function renderEditorPicks() {
                const picks = Object.entries(articles).filter(([k, v]) => v.type === 'editor' || getViews(k) > 30000).slice(0,
                    3);
                document.getElementById('editorPicks').innerHTML = picks.map(([slug, v]) => `
    <div class="news-list-item" style="padding:8px 0;" onclick="openArticle('${slug}')">
      <div class="nli-img" style="width:60px;height:44px;font-size:20px;">${v.hero}</div>
      <div>
        <div class="nli-title" style="font-size:12px;">${v.title}</div>
        <div class="nli-meta">${fmtNum(getViews(slug))} views</div>
      </div>
    </div>
  `).join('');
            }

            function renderCategoryWidget() {
                const cats = [
                    ['politik', '🏛️ Politik'],
                    ['ekonomi', '💹 Ekonomi'],
                    ['olahraga', '⚽ Olahraga'],
                    ['teknologi', '💻 Teknologi'],
                    ['kesehatan', '🩺 Kesehatan'],
                    ['budaya', '🎭 Budaya']
                ];
                document.getElementById('categoryWidget').innerHTML = cats.map(([cat, label]) => `
    <div style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:600;transition:.15s;"
      onclick="setNav(null,'${cat}')"
      onmouseover="this.style.borderColor='var(--red)';this.style.color='var(--red)'"
      onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text)'">${label}</div>
  `).join('');
            }

            function renderRelatedArticles(currentSlug, cat) {
                const related = Object.entries(articles)
                    .filter(([k, v]) => k !== currentSlug && v.category === cat)
                    .slice(0, 4);

                const fallback = Object.entries(articles)
                    .filter(([k]) => k !== currentSlug)
                    .sort((a, b) => getViews(b[0]) - getViews(a[0]))
                    .slice(0, 4);

                const list = related.length >= 2 ? related : fallback;
                document.getElementById('relatedArticles').innerHTML = list.map(([slug, v]) => `
    <div class="news-list-item" style="padding:8px 0;" onclick="openArticle('${slug}')">
      <div class="nli-img" style="width:60px;height:44px;font-size:18px;">${v.hero}</div>
      <div>
        <div class="nli-title" style="font-size:12px;">${v.title}</div>
        <div class="nli-meta">${fmtNum(getViews(slug))} views</div>
      </div>
    </div>
  `).join('');
            }

            function renderArtSidebarTrending() {
                const sorted = Object.entries(articles)
                    .sort((a, b) => getViews(b[0]) - getViews(a[0]))
                    .slice(0, 4);
                document.getElementById('artSidebarTrending').innerHTML = sorted.map(([slug, v], i) => `
    <div class="trending-item" onclick="openArticle('${slug}')">
      <div class="tr-rank">${String(i+1).padStart(2,'0')}</div>
      <div>
        <div class="tr-title">${v.title}</div>
        <div class="tr-views">👁 ${fmtNum(getViews(slug))}</div>
      </div>
    </div>
  `).join('');
            }

            // ═══════════════════════════════════════════════════
            // SEARCH — Real-time with dropdown
            // ═══════════════════════════════════════════════════
            let searchTimeout = null;

            function liveSearch(q) {
                clearTimeout(searchTimeout);
                const dropdown = document.getElementById('searchDropdown');

                if (!q || q.length < 2) {
                    closeSearchDropdown();
                    return;
                }

                searchTimeout = setTimeout(() => {
                    const query = q.toLowerCase();
                    const matches = Object.entries(articles).filter(([k, v]) =>
                        v.title.toLowerCase().includes(query) ||
                        v.author.toLowerCase().includes(query) ||
                        v.cat.toLowerCase().includes(query) ||
                        (v.tags || []).some(t => t.includes(query))
                    );

                    if (matches.length === 0) {
                        dropdown.innerHTML =
                            `<div class="sd-empty">Tidak ditemukan artikel untuk "<strong>${q}</strong>"</div>`;
                    } else {
                        const catMatches = matches.filter(([k, v]) => v.cat.toLowerCase().includes(query));
                        const titleMatches = matches.filter(([k, v]) => !v.cat.toLowerCase().includes(query));

                        let html = '';
                        if (catMatches.length) {
                            html += `<div class="sd-header">Kategori · ${catMatches.length} hasil</div>`;
                            html += catMatches.slice(0, 2).map(([slug, v]) => `
          <div class="sd-item" onclick="setNav(null,'${v.category}');closeSearchDropdown()">
            <div class="sd-emoji">${v.hero}</div>
            <div class="sd-info">
              <div class="sd-cat">${v.cat}</div>
              <div class="sd-title">Lihat semua berita ${v.cat} →</div>
            </div>
          </div>`).join('');
                        }
                        if (titleMatches.length || matches.length) {
                            html += `<div class="sd-header">Artikel · ${matches.length} hasil</div>`;
                            html += matches.slice(0, 5).map(([slug, v]) => `
          <div class="sd-item" onclick="openArticle('${slug}');closeSearchDropdown()">
            <div class="sd-emoji">${v.hero}</div>
            <div class="sd-info">
              <div class="sd-cat">${v.cat}</div>
              <div class="sd-title">${highlightMatch(v.title, query)}</div>
              <div class="sd-meta">${v.author} · 👁 ${fmtNum(getViews(slug))}</div>
            </div>
          </div>`).join('');
                        }
                        if (matches.length > 5) {
                            html += `<div class="sd-item" onclick="doSearch()" style="justify-content:center;color:var(--red);font-weight:700;">
          Lihat semua ${matches.length} hasil →</div>`;
                        }
                        dropdown.innerHTML = html;
                    }

                    dropdown.classList.add('open');
                }, 250);
            }

            function highlightMatch(text, query) {
                const re = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi');
                return text.replace(re, '<mark style="background:#ffd;padding:0 1px;border-radius:2px">$1</mark>');
            }

            function handleSearchKey(e) {
                if (e.key === 'Enter') {
                    closeSearchDropdown();
                    doSearch();
                }
                if (e.key === 'Escape') closeSearchDropdown();
            }

            function doSearch() {
                const q = document.getElementById('searchInput').value.trim();
                if (!q) return;

                closeSearchDropdown();
                state.searchQuery = q;
                const query = q.toLowerCase();

                const matches = Object.entries(articles).filter(([k, v]) =>
                    v.title.toLowerCase().includes(query) ||
                    v.author.toLowerCase().includes(query) ||
                    v.cat.toLowerCase().includes(query) ||
                    (v.tags || []).some(t => t.includes(query))
                );

                // Get unique categories in results
                const catsInResult = [...new Set(matches.map(([k, v]) => v.category))];

                document.getElementById('srTitle').textContent = `Hasil pencarian: "${q}"`;
                document.getElementById('srSub').textContent = `Ditemukan ${matches.length} berita`;

                // Category filter chips
                document.getElementById('srFilters').innerHTML = [
                    `<div class="sr-filter-chip active" onclick="filterSearchResults('all',this)">Semua (${matches.length})</div>`,
                    ...catsInResult.map(cat => {
                        const count = matches.filter(([k, v]) => v.category === cat).length;
                        const m = catMeta[cat] || {
                            icon: '📰',
                            label: cat
                        };
                        return `<div class="sr-filter-chip" onclick="filterSearchResults('${cat}',this)">${m.icon} ${m.label} (${count})</div>`;
                    })
                ].join('');

                renderSearchResults(matches, q);

                // Switch to search view (within home view)
                document.getElementById('homeView').style.display = 'block';
                document.getElementById('articleView').style.display = 'none';
                document.getElementById('heroSection').style.display = 'none';
                document.getElementById('catPageHeader').style.display = 'none';
                document.getElementById('searchResultsPage').classList.add('active');

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function filterSearchResults(cat, el) {
                document.querySelectorAll('.sr-filter-chip').forEach(c => c.classList.remove('active'));
                el.classList.add('active');

                const q = state.searchQuery;
                const query = q.toLowerCase();
                let matches = Object.entries(articles).filter(([k, v]) =>
                    v.title.toLowerCase().includes(query) ||
                    v.author.toLowerCase().includes(query) ||
                    v.cat.toLowerCase().includes(query)
                );
                if (cat !== 'all') matches = matches.filter(([k, v]) => v.category === cat);
                renderSearchResults(matches, q);
            }

            function renderSearchResults(matches, q) {
                const query = q.toLowerCase();
                const html = matches.map(([k, v]) => `
    <div class="news-list-item" onclick="openArticle('${k}')">
      <div class="nli-img">${v.hero}</div>
      <div>
        <div class="nli-cat" style="color:${getCatColor(v.category)}">${v.cat}</div>
        <div class="nli-title">${highlightMatch(v.title, query)}</div>
        <div class="nli-meta">${v.author} · ${v.date || '10 Mar 2026'} · 👁 ${fmtNum(getViews(k))} views</div>
      </div>
    </div>
  `).join('');

                document.getElementById('srContent').innerHTML = html || `
    <div class="empty-state">
      <div class="es-icon">🔍</div>
      <div class="es-title">Tidak ada hasil</div>
      <div class="es-sub">Coba kata kunci yang berbeda</div>
    </div>`;
            }

            function closeSearchDropdown() {
                document.getElementById('searchDropdown').classList.remove('open');
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!document.getElementById('searchWrap').contains(e.target)) {
                    closeSearchDropdown();
                }
            });

            // ═══════════════════════════════════════════════════
            // NAV MORE DROPDOWN
            // ═══════════════════════════════════════════════════
            function toggleNavMore() {
                document.getElementById('navMoreDropdown').classList.toggle('open');
            }

            function closeNavMore() {
                document.getElementById('navMoreDropdown').classList.remove('open');
            }

            document.addEventListener('click', function(e) {
                if (!document.getElementById('navMore').contains(e.target)) {
                    closeNavMore();
                }
            });

            // ═══════════════════════════════════════════════════
            // REACTIONS, COMMENTS, SHARE
            // ═══════════════════════════════════════════════════
            function react(type) {
                document.querySelectorAll('.reaction-btn').forEach(r => r.classList.remove('active'));
                const btn = document.getElementById('rb-' + type);
                btn.classList.add('active');
                const countEl = document.getElementById('rc-' + type);
                const prev = parseInt(countEl.textContent);
                countEl.textContent = prev + 1;
                showToast('Reaksi Anda tercatat!');
            }

            function submitComment() {
                const name = document.getElementById('cmtName').value.trim() || 'Anonim';
                const text = document.getElementById('cmtInput').value.trim();
                if (!text) {
                    showToast('⚠️ Tulis komentar terlebih dahulu');
                    return;
                }

                const list = document.getElementById('commentsList');
                const div = document.createElement('div');
                div.className = 'comment-item';
                div.style.animation = 'slideIn .3s ease';
                div.innerHTML = `
    <div class="ci-avatar" style="background:var(--red);color:#fff">${name[0].toUpperCase()}</div>
    <div class="ci-body">
      <div class="ci-user">${name} <span style="background:#e6f4ec;color:#1a7a3c;font-size:10px;padding:2px 6px;border-radius:8px;font-weight:700;margin-left:6px;">Baru</span></div>
      <div class="ci-time">Baru saja</div>
      <div class="ci-text">${text}</div>
      <div class="ci-acts"><span class="ci-act" onclick="likeComment(this)">👍 Suka (0)</span><span class="ci-act">↩ Balas</span></div>
    </div>`;
                list.prepend(div);
                document.getElementById('cmtInput').value = '';
                const t = document.getElementById('totalCmt');
                t.textContent = parseInt(t.textContent) + 1;
                showToast('✅ Komentar berhasil dikirim!');
            }

            function likeComment(el) {
                const match = el.textContent.match(/\((\d+)\)/);
                const count = match ? parseInt(match[1]) + 1 : 1;
                el.textContent = `👍 Suka (${count})`;
                el.style.color = 'var(--red)';
            }

            function share(platform) {
                const title = document.getElementById('artTitle').textContent;
                const url = window.location.href;
                const urls = {
                    facebook: `https://facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
                    twitter: `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`,
                    whatsapp: `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`,
                };
                if (urls[platform]) window.open(urls[platform], '_blank');
            }

            function copyLink() {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showToast('📋 Link berhasil disalin!');
                }).catch(() => showToast('Gagal menyalin link'));
            }

            function openSocial(platform) {
                const urls = {
                    facebook: 'https://facebook.com',
                    instagram: 'https://instagram.com',
                    twitter: 'https://twitter.com',
                    whatsapp: 'https://wa.me',
                };
                if (urls[platform]) window.open(urls[platform], '_blank');
            }

            // ═══════════════════════════════════════════════════
            // API ADAPTER — Siap diganti dengan Laravel fetch
            // ═══════════════════════════════════════════════════
            /*
              Contoh penggunaan API Laravel:

              async function fetchArticles(params = {}) {
                const qs = new URLSearchParams(params).toString();
                const res = await fetch(`/api/articles?${qs}`);
                const data = await res.json();
                return data.data; // Laravel paginated
              }

              async function fetchTrending() {
                const res = await fetch('/api/articles/trending');
                return await res.json();
              }

              // Ganti Object.entries(articles) dengan:
              // const list = await fetchArticles({ category: cat, sort: 'latest' });
              // renderMainGrid(list.map(a => [a.slug, a]));
            */

            // ═══════════════════════════════════════════════════
            // INIT
            // ═══════════════════════════════════════════════════
            document.addEventListener('DOMContentLoaded', () => {
                showHomeView();

                // Auto-update trending every 30 seconds (simulates real-time)
                setInterval(() => {
                    // Random small view bump to simulate live traffic
                    const slugs = Object.keys(articles);
                    const randomSlug = slugs[Math.floor(Math.random() * slugs.length)];
                    state.viewCounts[randomSlug] = (state.viewCounts[randomSlug] || getViews(randomSlug)) + Math
                        .floor(Math.random() * 5 + 1);

                    // Re-render trending if sidebar visible
                    if (document.getElementById('trendingWidget')) {
                        renderTrendingWidget();
                    }
                }, 30000);
            });
        </script>
    @endsection
