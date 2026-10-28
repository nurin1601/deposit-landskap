<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pengiraan Deposit Penyelenggaraan Landskap | MDHT</title>
    <link rel="icon" href="{{ asset('images/logo-mdht.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; color: #1a2e1a; background: #fff; }

        /* ─── Navbar ─── */
        .hp-nav {
            background: linear-gradient(90deg, #052e16 0%, #14532d 100%);
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 16px rgba(5,46,22,.35);
        }
        .hp-nav-inner {
            max-width: 1100px; margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .hp-nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .hp-nav-brand img { height: 40px; width: auto; }
        .hp-nav-brand-text { display: flex; flex-direction: column; }
        .hp-nav-brand-text span:first-child { color: #fff; font-weight: 700; font-size: .85rem; letter-spacing: .04em; line-height: 1.2; }
        .hp-nav-brand-text span:last-child  { color: #86efac; font-size: .72rem; line-height: 1.2; margin-top: 1px; }
        .hp-nav-links { display: flex; align-items: center; gap: 32px; }
        .hp-nav-links a {
            color: #d1fae5; font-size: .85rem; font-weight: 500; text-decoration: none;
            padding-bottom: 3px; border-bottom: 2px solid transparent;
            transition: color .18s, border-color .18s;
        }
        .hp-nav-links a:hover, .hp-nav-links a.active { color: #fff; border-bottom-color: #4ade80; }
        .hp-nav-lang {
            display: flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
            border-radius: 9999px; padding: 4px 10px;
            color: #d1fae5; font-size: .8rem; font-weight: 500; cursor: pointer;
        }
        /* Mobile nav toggle */
        .hp-nav-toggle { display: none; background: none; border: none; cursor: pointer; padding: 4px; }
        .hp-nav-toggle svg { color: #fff; }
        @media (max-width: 768px) {
            .hp-nav-links { display: none; position: absolute; top: 64px; left: 0; right: 0;
                background: linear-gradient(90deg, #052e16 0%, #14532d 100%); flex-direction: column; gap: 0; padding: 8px 0; }
            .hp-nav-links.open { display: flex; }
            .hp-nav-links a { padding: 12px 24px; border-bottom: none; border-left: 3px solid transparent; width: 100%; }
            .hp-nav-links a.active { border-left-color: #4ade80; background: rgba(74,222,128,.07); }
            .hp-nav-lang { display: none; }
            .hp-nav-toggle { display: block; }
        }

        /* ─── Hero ─── */
        .hp-hero {
            background: linear-gradient(160deg, #d1fae5 0%, #ecfdf5 40%, #f0fdf4 100%);
            padding: 72px 0 0;
        }
        .hp-hero-inner {
            max-width: 1100px; margin: 0 auto; padding: 0 24px;
            display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;
        }
        @media (max-width: 900px) {
            .hp-hero-inner { grid-template-columns: 1fr; gap: 32px; }
            .hp-hero { padding: 48px 0 0; }
        }
        .hp-hero-eyebrow {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: .78rem; font-weight: 600; color: #16a34a; letter-spacing: .06em;
            text-transform: uppercase; margin-bottom: 20px;
        }
        .hp-hero-eyebrow::before { content: ''; display: block; width: 8px; height: 8px; background: #16a34a; border-radius: 50%; }
        .hp-hero h1 {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800; line-height: 1.18; color: #14532d;
            margin-bottom: 18px; letter-spacing: -.02em;
        }
        .hp-hero-sub {
            font-size: 1rem; color: #4b5563; line-height: 1.65;
            margin-bottom: 32px; max-width: 420px;
        }
        .hp-hero-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; }
        .hp-btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 26px; background: linear-gradient(90deg, #052e16 0%, #14532d 100%);
            color: #fff; font-weight: 700; font-size: .9rem; border-radius: 9999px;
            text-decoration: none; border: none; cursor: pointer;
            box-shadow: 0 4px 14px rgba(20,83,45,.35);
            transition: transform .18s, box-shadow .18s, filter .18s;
        }
        .hp-btn-primary:hover { transform: translateY(-2px); filter: brightness(1.1); box-shadow: 0 8px 22px rgba(20,83,45,.42); }
        .hp-btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 24px; background: #fff; color: #14532d;
            font-weight: 600; font-size: .9rem; border-radius: 9999px;
            text-decoration: none; border: 1.5px solid #16a34a; cursor: pointer;
            transition: transform .18s, background .18s, box-shadow .18s;
        }
        .hp-btn-outline:hover { background: #f0fdf4; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(20,83,45,.18); }
        .hp-hero-hint { font-size: .78rem; color: #6b7280; display: flex; align-items: center; gap: 6px; }
        .hp-hero-hint svg { color: #16a34a; flex-shrink: 0; }
        .hp-hero-hint a { color: #16a34a; font-weight: 600; text-decoration: none; }
        .hp-hero-hint a:hover { text-decoration: underline; }

        /* Hero image box */
        .hp-hero-img-wrap {
            position: relative; border-radius: 20px; overflow: hidden;
            box-shadow: 0 16px 48px rgba(5,46,22,.22), 0 4px 12px rgba(0,0,0,.1);
            aspect-ratio: 4/3;
        }
        .hp-hero-img-wrap img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        /* fallback gradient if image missing/loading */
        .hp-hero-img-fallback {
            width: 100%; height: 100%;
            background: linear-gradient(145deg, #166534 0%, #15803d 35%, #22c55e 70%, #86efac 100%);
        }
        .hp-hero-img-caption {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: linear-gradient(0deg, rgba(5,46,22,.92) 0%, rgba(5,46,22,.6) 70%, transparent 100%);
            padding: 28px 20px 20px;
        }
        .hp-hero-img-caption-label {
            font-size: .68rem; font-weight: 600; color: #86efac;
            letter-spacing: .1em; text-transform: uppercase; margin-bottom: 6px;
        }
        .hp-hero-img-caption p { color: #fff; font-size: 1rem; font-weight: 700; line-height: 1.35; }

        /* ─── Features strip ─── */
        .hp-features { background: #fff; padding: 60px 0; }
        .hp-features-inner {
            max-width: 1100px; margin: 0 auto; padding: 0 24px;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        @media (max-width: 768px) { .hp-features-inner { grid-template-columns: 1fr; } }
        .hp-feature-card {
            background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 28px 24px; transition: box-shadow .2s, transform .2s;
        }
        .hp-feature-card:hover { box-shadow: 0 8px 28px rgba(20,83,45,.1); transform: translateY(-3px); }
        .hp-feature-icon {
            width: 44px; height: 44px; background: #dcfce7; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
            color: #16a34a;
        }
        .hp-feature-card h3 { font-size: .95rem; font-weight: 700; color: #14532d; margin-bottom: 8px; }
        .hp-feature-card p  { font-size: .85rem; color: #6b7280; line-height: 1.6; }

        /* ─── Steps ─── */
        .hp-steps { background: #f9fafb; padding: 72px 0; }
        .hp-steps-inner { max-width: 1100px; margin: 0 auto; padding: 0 24px; }
        .hp-section-eyebrow {
            font-size: .72rem; font-weight: 700; color: #16a34a;
            letter-spacing: .1em; text-transform: uppercase; margin-bottom: 10px;
        }
        .hp-steps-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; margin-bottom: 40px; flex-wrap: wrap; }
        .hp-steps-header h2 { font-size: clamp(1.6rem, 3vw, 2.1rem); font-weight: 800; color: #14532d; line-height: 1.2; }
        .hp-steps-header p  { font-size: .85rem; color: #9ca3af; text-align: right; max-width: 240px; }
        .hp-steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        @media (max-width: 768px) { .hp-steps-grid { grid-template-columns: 1fr; } }
        .hp-step-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 28px 24px; position: relative;
            transition: box-shadow .2s, transform .2s;
        }
        .hp-step-card:hover { box-shadow: 0 8px 28px rgba(20,83,45,.1); transform: translateY(-3px); }
        .hp-step-num {
            font-size: .75rem; font-weight: 700; color: #d1d5db; letter-spacing: .06em;
            margin-bottom: 12px;
        }
        .hp-step-icon {
            width: 38px; height: 38px; color: #16a34a;
            position: absolute; top: 24px; right: 24px;
        }
        .hp-step-card h3 { font-size: 1rem; font-weight: 700; color: #14532d; margin-bottom: 10px; }
        .hp-step-card p  { font-size: .84rem; color: #6b7280; line-height: 1.6; }

        /* ─── Dark CTA ─── */
        .hp-cta { background: #052e16; padding: 64px 0; }
        .hp-cta-inner {
            max-width: 1100px; margin: 0 auto; padding: 0 24px;
            display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: center;
        }
        @media (max-width: 768px) { .hp-cta-inner { grid-template-columns: 1fr; gap: 32px; } }
        .hp-cta-eyebrow { font-size: .7rem; font-weight: 700; color: #4ade80; letter-spacing: .12em; text-transform: uppercase; margin-bottom: 14px; }
        .hp-cta h2 { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; color: #fff; line-height: 1.25; margin-bottom: 16px; }
        .hp-cta-sub { font-size: .88rem; color: #86efac; line-height: 1.6; margin-bottom: 20px; }
        .hp-cta-link { display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; font-weight: 600; color: #4ade80; text-decoration: none; }
        .hp-cta-link:hover { text-decoration: underline; }
        .hp-cta-checklist { display: flex; flex-direction: column; gap: 20px; }
        .hp-cta-item { display: flex; gap: 14px; align-items: flex-start; }
        .hp-cta-check {
            width: 24px; height: 24px; background: rgba(74,222,128,.15); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;
            color: #4ade80;
        }
        .hp-cta-item-text h4 { font-size: .9rem; font-weight: 700; color: #fff; margin-bottom: 3px; }
        .hp-cta-item-text p  { font-size: .82rem; color: #6ee7b7; line-height: 1.5; }

        /* ─── FAQ ─── */
        .hp-faq { background: #fff; padding: 72px 0; }
        .hp-faq-inner {
            max-width: 1100px; margin: 0 auto; padding: 0 24px;
            display: grid; grid-template-columns: 1fr 2fr; gap: 64px; align-items: start;
        }
        @media (max-width: 768px) { .hp-faq-inner { grid-template-columns: 1fr; gap: 32px; } }
        .hp-faq-left h2 { font-size: clamp(1.6rem, 3vw, 2.1rem); font-weight: 800; color: #14532d; margin-bottom: 12px; }
        .hp-faq-left p   { font-size: .88rem; color: #6b7280; line-height: 1.65; margin-bottom: 20px; }
        .hp-faq-guide-link { display: inline-flex; align-items: center; gap: 6px; font-size: .84rem; font-weight: 600; color: #16a34a; text-decoration: none; }
        .hp-faq-guide-link:hover { text-decoration: underline; }
        /* Accordion */
        .hp-faq-accordion { display: flex; flex-direction: column; }
        .hp-faq-item { border-bottom: 1px solid #e5e7eb; }
        .hp-faq-q {
            width: 100%; background: none; border: none; text-align: left;
            padding: 20px 0; display: flex; justify-content: space-between; align-items: center;
            gap: 12px; cursor: pointer; font-family: inherit;
        }
        .hp-faq-q span { font-size: .9rem; font-weight: 700; color: #14532d; }
        .hp-faq-q svg { color: #16a34a; flex-shrink: 0; transition: transform .25s; }
        .hp-faq-q[aria-expanded="true"] svg { transform: rotate(45deg); }
        .hp-faq-a {
            font-size: .85rem; color: #4b5563; line-height: 1.7;
            max-height: 0; overflow: hidden;
            transition: max-height .3s ease, padding .3s ease;
        }
        .hp-faq-a.open { max-height: 200px; padding-bottom: 18px; }

        /* ─── Footer ─── */
        .hp-footer { background: linear-gradient(90deg, #052e16 0%, #14532d 100%); padding: 48px 0 0; }
        .hp-footer-inner {
            max-width: 1100px; margin: 0 auto; padding: 0 24px 40px;
            display: flex; justify-content: space-between; align-items: flex-start; gap: 32px; flex-wrap: wrap;
        }
        .hp-footer-brand { display: flex; gap: 14px; align-items: flex-start; max-width: 300px; }
        .hp-footer-brand img { height: 44px; width: auto; margin-top: 2px; }
        .hp-footer-brand-text h3 { color: #fff; font-size: .9rem; font-weight: 700; margin-bottom: 4px; }
        .hp-footer-brand-text p  { color: #86efac; font-size: .78rem; line-height: 1.5; }
        .hp-footer-links h4 { color: #d1fae5; font-size: .78rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 14px; }
        .hp-footer-links ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .hp-footer-links a { color: #86efac; font-size: .85rem; text-decoration: none; transition: color .15s; }
        .hp-footer-links a:hover { color: #fff; }
        .hp-footer-bar {
            background: rgba(0,0,0,.2); border-top: 1px solid rgba(255,255,255,.08);
            padding: 14px 24px;
        }
        .hp-footer-bar-inner {
            max-width: 1100px; margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;
        }
        .hp-footer-bar p { color: #6ee7b7; font-size: .75rem; }
    </style>
</head>
<body x-data="{ mobileNavOpen: false }">

{{-- ═══ NAVBAR ═══ --}}
<nav class="hp-nav">
    <div class="hp-nav-inner">
        <a href="{{ route('home') }}" class="hp-nav-brand">
            <img src="{{ asset('images/logo-mdht.png') }}" alt="Logo MDHT">
            <div class="hp-nav-brand-text">
                <span>MAJLIS DAERAH HULU TERENGGANU</span>
                <span>Sistem Pengiraan Deposit Penyelenggaraan Landskap</span>
            </div>
        </a>

        <div class="hp-nav-links" :class="{ 'open': mobileNavOpen }">
            <a href="{{ route('home') }}" class="active">Laman Utama</a>
            <a href="#cara-penggunaan">Cara Penggunaan</a>
            <a href="#soalan-lazim">Soalan Lazim</a>
        </div>

        <div style="display:flex;align-items:center;gap:12px;">
            <div class="hp-nav-lang">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                BM
            </div>
            <button class="hp-nav-toggle" @click="mobileNavOpen = !mobileNavOpen" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <template x-if="!mobileNavOpen"><g><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></g></template>
                    <template x-if="mobileNavOpen"><g><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></g></template>
                </svg>
            </button>
        </div>
    </div>
</nav>

{{-- ═══ HERO ═══ --}}
<section class="hp-hero">
    <div class="hp-hero-inner">
        {{-- Left --}}
        <div>
            <div class="hp-hero-eyebrow">Selamat datang ke perkhidmatan landskap MDHT</div>
            <h1>Sistem Pengiraan Deposit Penyelenggaraan Landskap</h1>
            <p class="hp-hero-sub">
                Mulakan pengiraan deposit landskap untuk projek pembangunan anda atau
                rujuk semula rekod pengiraan dalam satu tempat.
            </p>
            <div class="hp-hero-actions">
                <a href="{{ route('calculations.create') }}" class="hp-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Pengiraan Baharu
                </a>
                <a href="{{ route('calculations.index') }}" class="hp-btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Senarai Pengiraan
                </a>
            </div>
            <p class="hp-hero-hint">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Kali pertama di sini?
                <a href="#cara-penggunaan">Lihat cara penggunaan di bawah.</a>
            </p>
        </div>

        {{-- Right – image with caption --}}
        @php $hasHeroImg = file_exists(public_path('images/taman-tropika.png')) && filesize(public_path('images/taman-tropika.png')) > 0; @endphp
        <div class="hp-hero-img-wrap">
            <img src="{{ asset('images/taman-tropika.png') }}"
                 alt="Kawasan landskap taman tropika"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                 style="{{ $hasHeroImg ? '' : 'display:none;' }}">
            <div class="hp-hero-img-fallback"
                 style="{{ $hasHeroImg ? 'display:none;' : '' }}"></div>
            <div class="hp-hero-img-caption">
                <div class="hp-hero-img-caption-label">Perkhidmatan Landskap</div>
                <p>Perancangan yang teratur bermula dengan maklumat yang jelas.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ FEATURES ═══ --}}
<section class="hp-features">
    <div class="hp-features-inner">
        {{-- 1 --}}
        <div class="hp-feature-card">
            <div class="hp-feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <h3>Maklumat lebih tersusun</h3>
            <p>Lengkapkan butiran projek dan maklumat landskap melalui borang pengiraan.</p>
        </div>
        {{-- 2 --}}
        <div class="hp-feature-card">
            <div class="hp-feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <h3>Pengiraan lebih terarah</h3>
            <p>Ikuti medan yang disediakan untuk menyediakan pengiraan deposit projek.</p>
        </div>
        {{-- 3 --}}
        <div class="hp-feature-card">
            <div class="hp-feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <h3>Rekod mudah dirujuk</h3>
            <p>Cari dan lihat semua pengiraan melalui halaman Senarai Pengiraan.</p>
        </div>
    </div>
</section>

{{-- ═══ CARA PENGGUNAAN ═══ --}}
<section class="hp-steps" id="cara-penggunaan">
    <div class="hp-steps-inner">
        <div class="hp-section-eyebrow">Cara Penggunaan</div>
        <div class="hp-steps-header">
            <h2>Tiga langkah untuk bermula</h2>
            <p>Daripada butiran projek kepada pengiraan.</p>
        </div>
        <div class="hp-steps-grid">
            {{-- Step 1 --}}
            <div class="hp-step-card">
                <div class="hp-step-num">01</div>
                <svg class="hp-step-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                <h3>Mulakan pengiraan</h3>
                <p>Tekan butang Pengiraan Baharu untuk membuka borang dan masukkan butiran projek.</p>
            </div>
            {{-- Step 2 --}}
            <div class="hp-step-card">
                <div class="hp-step-num">02</div>
                <svg class="hp-step-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <h3>Lengkapkan maklumat</h3>
                <p>Isikan maklumat landskap yang diminta. Semak semua butiran sebelum meneruskan.</p>
            </div>
            {{-- Step 3 --}}
            <div class="hp-step-card">
                <div class="hp-step-num">03</div>
                <svg class="hp-step-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                <h3>Semak &amp; rujuk rekod</h3>
                <p>Semak hasil pengiraan. Gunakan Senarai Pengiraan untuk mencari semula rekod projek.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ DARK CTA ═══ --}}
<section class="hp-cta">
    <div class="hp-cta-inner">
        <div>
            <div class="hp-cta-eyebrow">Sebelum Anda Bermula</div>
            <h2>Sediakan maklumat, mudahkan pengiraan.</h2>
            <p class="hp-cta-sub">
                Gunakan senarai semak ringkas ini sebagai persediaan
                sebelum mengisi borang.
            </p>
            <a href="#cara-penggunaan" class="hp-cta-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Panduan persediaan, bukan senarai dokumen wajib.
            </a>
        </div>
        <div class="hp-cta-checklist">
            <div class="hp-cta-item">
                <div class="hp-cta-check">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="hp-cta-item-text">
                    <h4>Nama dan butiran projek</h4>
                    <p>Sediakan nama projek serta penerangan pembangunan.</p>
                </div>
            </div>
            <div class="hp-cta-item">
                <div class="hp-cta-check">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="hp-cta-item-text">
                    <h4>Jenis pembangunan</h4>
                    <p>Kenali pasti kategori yang berkaitan dengan projek anda.</p>
                </div>
            </div>
            <div class="hp-cta-item">
                <div class="hp-cta-check">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="hp-cta-item-text">
                    <h4>Maklumat landskap projek</h4>
                    <p>Rujuk pelan atau dokumen projek untuk butiran yang diminta dalam borang.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ FAQ ═══ --}}
<section class="hp-faq" id="soalan-lazim">
    <div class="hp-faq-inner">
        <div class="hp-faq-left">
            <div class="hp-section-eyebrow">Bantuan Ringkas</div>
            <h2>Ada pertanyaan?</h2>
            <p>Rujuk jawapan ringkas sebelum anda meneruskan pengiraan.</p>
            <a href="#cara-penggunaan" class="hp-faq-guide-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Panduan penggunaan sistem
            </a>
        </div>

        <div class="hp-faq-accordion" x-data="{ open: null }">
            {{-- Q1 --}}
            <div class="hp-faq-item">
                <button class="hp-faq-q" @click="open = open === 1 ? null : 1" :aria-expanded="open === 1">
                    <span>Bagaimana saya memulakan pengiraan?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
                <div class="hp-faq-a" :class="{ 'open': open === 1 }">
                    Pilih <strong>Pengiraan Baharu</strong> di bahagian atas halaman ini. Lengkapkan maklumat projek dan ikuti medan yang disediakan dalam borang.
                </div>
            </div>
            {{-- Q2 --}}
            <div class="hp-faq-item">
                <button class="hp-faq-q" @click="open = open === 2 ? null : 2" :aria-expanded="open === 2">
                    <span>Di mana saya boleh mencari pengiraan terdahulu?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
                <div class="hp-faq-a" :class="{ 'open': open === 2 }">
                    Buka <strong>Senarai Pengiraan</strong> dan gunakan carian nama projek untuk mencari rekod yang ingin dirujuk.
                </div>
            </div>
            {{-- Q3 --}}
            <div class="hp-faq-item">
                <button class="hp-faq-q" @click="open = open === 3 ? null : 3" :aria-expanded="open === 3">
                    <span>Bagaimana jika saya kurang pasti tentang maklumat projek?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
                <div class="hp-faq-a" :class="{ 'open': open === 3 }">
                    Semak pelan atau dokumen projek terlebih dahulu. Untuk penjelasan berkaitan keperluan landskap, rujuk pihak Majlis Daerah Hulu Terengganu.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ FOOTER ═══ --}}
<footer class="hp-footer">
    <div class="hp-footer-inner">
        <div class="hp-footer-brand">
            <img src="{{ asset('images/logo-mdht.png') }}" alt="Logo MDHT">
            <div class="hp-footer-brand-text">
                <h3>MAJLIS DAERAH HULU TERENGGANU</h3>
                <p>Sistem Pengiraan Deposit Penyelenggaraan Landskap</p>
            </div>
        </div>
        <div class="hp-footer-links">
            <h4>Pautan Cepat</h4>
            <ul>
                <li><a href="{{ route('calculations.create') }}">Pengiraan Baharu</a></li>
                <li><a href="{{ route('calculations.index') }}">Senarai Pengiraan</a></li>
                <li><a href="#cara-penggunaan">Cara Penggunaan</a></li>
            </ul>
        </div>
    </div>
    <div class="hp-footer-bar">
        <div class="hp-footer-bar-inner">
            <p>&copy; {{ date('Y') }} Majlis Daerah Hulu Terengganu. Semua hak terpelihara.</p>
            <p>Perkhidmatan Pengiraan Deposit Landskap</p>
        </div>
    </div>
</footer>

</body>
</html>
