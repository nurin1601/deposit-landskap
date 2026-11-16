<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deposit Penyelenggaraan Landskap | MDHT</title>
    <link rel="icon" href="{{ asset('images/logo-mdht.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(160deg, #d1fae5 0%, #e6ece7 40%, #f0f4f1 100%);
            min-height: 100vh;
        }

        /* ── Cards ── */
        .card {
            background: #ffffff;
            border: 1px solid #d1fae5;
            border-top: 4px solid #15803d;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(20,83,45,.08), 0 1px 3px rgba(0,0,0,.06);
            padding: 24px;
            transition: box-shadow .2s ease;
        }
        .card:hover { box-shadow: 0 6px 24px rgba(20,83,45,.12), 0 2px 6px rgba(0,0,0,.07); }
        .card-title {
            font-weight: 700; font-size: 1.05rem; color: #14532d;
            display: flex; align-items: center; gap: 8px;
        }
        .card-title::before {
            content: '';
            display: inline-block; width: 4px; height: 1.1em;
            background: #16a34a; border-radius: 3px;
        }

        .page-container {
            max-width: 1300px;
            margin-left: auto;
            margin-right: auto;
            padding-left: clamp(24px, 4vw, 64px);
            padding-right: clamp(24px, 4vw, 64px);
        }

        /* ── Inputs ── */
        input, select, textarea {
            font-family: inherit;
            transition: border-color .15s, box-shadow .15s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #16a34a !important;
            box-shadow: 0 0 0 3px rgba(22,163,74,.18);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            padding: 9px 22px; border-radius: 9999px; border: 1.5px solid transparent;
            font-family: inherit; font-weight: 600; font-size: .875rem;
            line-height: 1.25; white-space: nowrap; text-decoration: none; cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, filter .18s ease, color .18s ease, border-color .18s ease;
            letter-spacing: .01em;
        }
        .btn:hover  { transform: translateY(-2px); }
        .btn:active { transform: translateY(0); box-shadow: none !important; }
        .btn:focus-visible { outline: 3px solid #86efac; outline-offset: 2px; }

        .btn-primary {
            background: linear-gradient(135deg, #16a34a, #14532d);
            color: #fff;
            box-shadow: 0 3px 10px rgba(20,83,45,.38);
        }
        .btn-primary:hover {
            filter: brightness(1.12);
            box-shadow: 0 8px 20px rgba(20,83,45,.42);
        }

        .btn-light {
            background: #fff; color: #14532d;
            border-color: rgba(255,255,255,.6);
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }
        .btn-light:hover { background: #f0fdf4; box-shadow: 0 6px 16px rgba(0,0,0,.2); }

        .btn-outline {
            background: #fff; color: #166534;
            border-color: #166534;
        }
        .btn-outline:hover {
            background: #166534; color: #fff;
            box-shadow: 0 4px 12px rgba(20,83,45,.28);
        }

        .btn-danger {
            background: #fef2f2; color: #dc2626;
            border-color: #fecaca;
        }
        .btn-danger:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        .btn-blue {
            background: #eff6ff; color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .btn-blue:hover { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }

        .btn-green-soft {
            background: #f0fdf4; color: #166534;
            border-color: #bbf7d0;
        }
        .btn-green-soft:hover { background: #166534; color: #fff; border-color: #166534; }

        .btn-nav {
            background: rgba(255,255,255,.12);
            color: #fff;
            border-color: rgba(255,255,255,.5);
        }
        .btn-nav:hover {
            background: rgba(255,255,255,.24);
            border-color: #fff;
            box-shadow: 0 6px 16px rgba(0,0,0,.25);
        }
        @media (max-width: 639px) { .btn-nav { display: none; } }

        .btn-sm   { padding: 5px 14px; font-size: .8rem; }
        .btn-icon {
            width: 32px; height: 32px; padding: 0;
            background: #fef2f2; color: #dc2626; border-radius: 50%;
        }
        .btn-icon:hover { background: #dc2626; color: #fff; }

        /* Menu pengguna */
        [x-cloak] { display: none !important; }
        .menu-item {
            display: flex; align-items: center; gap: 10px; width: 100%;
            padding: 9px 12px; border-radius: 8px;
            font-family: inherit; font-size: .875rem; font-weight: 500; text-align: left;
            color: #14532d; text-decoration: none;
            background: none; border: none; cursor: pointer;
        }
        .menu-item:hover { background: #f0fdf4; }
        .menu-item-danger { color: #dc2626; }
        .menu-item-danger:hover { background: #fef2f2; }
        .menu-sep { height: 1px; background: #e5e7eb; margin: 6px 0; }

        /* ── Flash Message ── */
        .flash-success {
            background: linear-gradient(90deg, #dcfce7, #f0fdf4);
            border-left: 4px solid #16a34a;
            color: #14532d;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex; align-items: center; gap: 10px;
            animation: slideIn .3s ease;
        }
        @keyframes slideIn {
            from { opacity:0; transform: translateY(-8px); }
            to   { opacity:1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-gray-800">

        {{-- ═══ NAVBAR ═══ --}}
        <nav class="bg-gradient-to-r from-green-950 to-green-800 shadow-lg sticky top-0 z-50">
            <div class="page-container py-3 flex items-center gap-4">

                {{-- Logo dan tajuk --}}
                <a href="{{ route('calculations.index') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-mdht.png') }}" alt="Logo MDHT"
                        class="h-12 w-auto drop-shadow-md transition-transform duration-300 group-hover:scale-105">
                    <div>
                        <div class="font-bold text-white text-sm sm:text-base leading-tight tracking-wide">
                            MAJLIS DAERAH HULU TERENGGANU
                        </div>
                        <div class="text-xs sm:text-sm text-green-300 mt-0.5">
                            Sistem Pengiraan Deposit Penyelenggaraan Landskap
                        </div>
                    </div>
                </a>

                {{-- Ikon laman utama --}}
                <a href="{{ route('home') }}" class="btn btn-nav btn-nav-icon shrink-0" style="margin-left: 6px;" title="Laman Utama" aria-label="Laman Utama">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </a>

                {{-- Nama pengguna dan log keluar (hanya selepas log masuk) --}}
                @auth
                    <div style="margin-left:auto; position:relative;" x-data="{ open: false }"
                        @click.outside="open = false" @keydown.escape.window="open = false">

                        <button type="button" @click="open = !open" class="btn btn-nav btn-sm"
                                aria-haspopup="true" :aria-expanded="open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>

                        <div x-show="open" x-cloak x-transition.opacity.duration.150ms
                            style="position:absolute; right:0; top:calc(100% + 10px); min-width:230px; background:#fff; border-radius:12px; border:1px solid #d1fae5; box-shadow:0 12px 32px rgba(5,46,22,.25); padding:6px; z-index:60;">

                            <div style="padding:8px 12px 6px;">
                                <div style="font-size:.8rem; font-weight:700; color:#14532d;">{{ auth()->user()->name }}</div>
                                <div style="font-size:.72rem; color:#6b7280;">{{ auth()->user()->email }}</div>
                            </div>
                            <div class="menu-sep"></div>

                            <a href="{{ route('account.password.edit') }}" class="menu-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 2-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0 3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                                Tukar kata laluan
                            </a>

                            @can('manage-users')
                                <a href="{{ route('users.index') }}" class="menu-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    Urus pengguna
                                </a>
                            @endcan

                            <div class="menu-sep"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="menu-item menu-item-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                    Log keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

            </div>
        </nav>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main class="flex-1 w-full page-container py-8">
        <div class='no-print'>
        @if (session('success'))
            <div class="flash-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        </div>
        @yield('content')
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="no-print bg-gradient-to-r from-green-950 to-green-800 text-green-300 text-center text-xs py-4 tracking-wide">
        &copy; {{ date('Y') }} Majlis Daerah Hulu Terengganu &mdash; Semua hak terpelihara
    </footer>

</body>
</html>