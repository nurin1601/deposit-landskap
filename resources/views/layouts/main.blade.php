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
        <div class="page-container py-3 flex justify-between items-center gap-4">
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
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('home') }}" class="btn btn-nav text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Laman Utama
                </a>
                <a href="{{ route('calculations.create') }}"
                   class="btn btn-light text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Pengiraan Baru
                </a>
            </div>
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