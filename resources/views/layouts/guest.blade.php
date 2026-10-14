<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Log Masuk &mdash; Deposit Landskap MDHT</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-8"
             style="background: linear-gradient(160deg, #052e16 0%, #14532d 50%, #15803d 100%);">

            {{-- Logo & Branding --}}
            <div class="mb-8 text-center">
                <a href="/" class="inline-flex flex-col items-center gap-3 group">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/20 transition-colors">
                        <x-application-logo class="w-16 h-16 fill-current text-white" />
                    </div>
                    <div>
                        <div class="text-white font-bold text-lg tracking-wide">MAJLIS DAERAH HULU TERENGGANU</div>
                        <div class="text-green-300 text-sm mt-0.5">Sistem Pengiraan Deposit Penyelenggaraan Landskap</div>
                    </div>
                </a>
            </div>

            {{-- Login Card --}}
            <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-green-400 to-green-700"></div>
                <div class="px-8 py-7">
                    {{ $slot }}
                </div>
            </div>

            <p class="text-green-400/60 text-xs mt-8">&copy; {{ date('Y') }} Majlis Daerah Hulu Terengganu</p>
        </div>
    </body>
</html>
