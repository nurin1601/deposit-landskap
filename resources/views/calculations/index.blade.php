@extends('layouts.main')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Senarai Pengiraan</h1>
    <p class="text-sm text-gray-500 mt-1">Rekod pengiraan deposit penyelenggaraan landskap</p>
</div>

{{-- Search & Filter --}}
<form method="GET" action="{{ route('calculations.index') }}"
      class="card mb-5 flex flex-wrap gap-3 items-center" style="padding: 14px 20px;">
    <div class="flex-1 min-w-[200px] relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
             xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="q" value="{{ $q }}"
               placeholder="Cari projek pembangunan..."
               class="w-full border border-gray-200 rounded-full pl-9 pr-4 py-2 text-sm focus:border-green-500 bg-gray-50">
    </div>
    <select name="sort" onchange="this.form.submit()"
            class="border border-gray-200 rounded-full px-4 py-2 text-sm bg-gray-50 cursor-pointer">
        <option value="newest" @selected($sort === 'newest')>🕐 Terbaru</option>
        <option value="oldest" @selected($sort === 'oldest')>🕐 Terlama</option>
        <option value="highest" @selected($sort === 'highest')>↑ Jumlah tertinggi</option>
        <option value="lowest" @selected($sort === 'lowest')>↓ Jumlah terendah</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    @if ($q !== '' || $sort !== 'newest')
        <a href="{{ route('calculations.index') }}" class="btn btn-outline btn-sm">✕ Reset</a>
    @endif
</form>

{{-- Record Count --}}
<div class="flex items-center justify-between mb-3">
    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-800 bg-green-100 px-3 py-1 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
        </svg>
        {{ $calculations->count() }} rekod dijumpai
    </span>
</div>

{{-- Table --}}
<div class="card overflow-x-auto" style="padding: 0; border-top-color: #15803d;">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gradient-to-r from-green-900 to-green-700 text-white text-left">
                <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider">Projek</th>
                <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider">Jenis Pembangunan</th>
                <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider text-right">Jumlah (RM)</th>
                <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider">Tarikh</th>
                <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wider text-right">Tindakan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($calculations as $c)
                <tr class="hover:bg-green-50/60 transition-colors duration-150 group">
                    <td class="px-5 py-3.5">
                        @if ($c->title)
                            <span class="font-semibold text-gray-800 group-hover:text-green-800 transition-colors">
                                {{ $c->title }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="font-medium text-gray-800 group-hover:text-green-800 transition-colors">
                            {{ \Illuminate\Support\Str::limit($c->development_type, 90) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <span class="font-semibold text-green-800">
                            RM {{ number_format($c->grand_total, 2) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">
                        {{ $c->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex justify-end gap-1.5 flex-wrap">
                            {{-- View --}}
                            <a href="{{ route('calculations.show', $c) }}"
                               class="btn btn-outline btn-sm" title="Lihat / Cetak">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Lihat
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('calculations.edit', $c) }}"
                               class="btn btn-sm"
                               style="background:#eff6ff; color:#1d4ed8; border:1.5px solid #bfdbfe;"
                               title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </a>

                            {{-- Duplicate --}}
                            <form method="POST" action="{{ route('calculations.duplicate', $c) }}"
                                  data-confirm-delete
                                  data-title="Salin pengiraan ini?"
                                  data-message="Satu salinan baru bagi '{{ $c->development_type }}' akan dibuat."
                                  data-icon="question"
                                  data-confirm-text="Ya, salin"
                                  data-confirm-color="#166534">
                                @csrf
                                <button type="submit" class="btn btn-sm"
                                        style="background:#f0fdf4; color:#166534; border:1.5px solid #bbf7d0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                    </svg>
                                    Salin
                                </button>
                            </form>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('calculations.destroy', $c) }}"
                                  data-confirm-delete
                                  data-title="Padam pengiraan ini?"
                                  data-message="Rekod '{{ $c->development_type }}' akan dipadam dan tidak boleh dipulihkan.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6"/>
                                    </svg>
                                    Padam
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                            <p class="font-medium text-gray-500">
                                {{ $q !== '' ? 'Tiada hasil untuk "' . $q . '".' : 'Belum ada pengiraan.' }}
                            </p>
                            @if ($q === '')
                                <a href="{{ route('calculations.create') }}" class="btn btn-primary btn-sm mt-1">
                                    + Buat Pengiraan Pertama
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection