@extends('layouts.main')

@section('content')
@php
    $a = $calculation->greenAreaRate;
    $rm = fn ($v) => 'RM ' . number_format($v, 2);
    $n = fn ($v) => rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.');
    $unitLabel = fn ($u) => match ($u) { 'pokok' => 'nos', 'm2' => 'm²', default => $u };
    $softGroups = $calculation->items->where('section', 'B')->groupBy('name');
    $hardItems = $calculation->items->where('section', 'C')->values();
@endphp

<style>
    .doc table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .doc td { border: 1px solid #333; padding: 7px 10px; vertical-align: top; }
    .doc .gray td { background: #d5e8d4; }
    .doc .bold td { font-weight: 700; }
    .doc .center td { text-align: center; }
    .doc .right { text-align: right; }
    @media print {
        nav, .no-print { display: none !important; }
        body { background: #fff; font-size: 12px; }
        main { padding: 0; max-width: none; }
        .doc { padding: 0; box-shadow: none; border: none !important; }
        .gray td { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>

{{-- No-print Action Bar --}}
<div class="no-print flex justify-between items-center mb-5">
    <a href="{{ route('calculations.index') }}"
       class="btn btn-outline btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali
    </a>

    <div class="flex items-center gap-3">
        <span class="text-xs text-gray-400 hidden sm:block">
            Pengiraan: <strong class="text-gray-600">{{ $calculation->created_at->format('d/m/Y') }}</strong>
        </span>
        <button onclick="window.print()" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Cetak / PDF
        </button>
    </div>
</div>

{{-- Document --}}
<div class="doc bg-white p-6 sm:p-8 shadow-sm border border-gray-100 rounded-xl">

    <table>
        <tr class="bold center">
            <td colspan="3">JENIS PEMBANGUNAN :<br>{{ strtoupper($calculation->development_type) }}</td>
            <td>PENGIRAAN</td>
        </tr>

        {{-- A --}}
        <tr class="gray bold"><td colspan="4">A) KAWASAN HIJAU – merangkumi semua skop pembersihan awam.</td></tr>
        <tr>
            <td colspan="3">{{ $a->category }}{{ $a->tier ? ' ' . $a->tier : '' }}</td>
            <td class="right">{{ $rm($calculation->total_a) }}</td>
        </tr>
        <tr class="bold">
            <td colspan="3">Jumlah Keseluruhan Kawasan Hijau (A)</td>
            <td class="right">{{ $rm($calculation->total_a) }}</td>
        </tr>

        {{-- B --}}
        <tr class="gray bold"><td colspan="4">B) LANDSKAP LEMBUT DALAM KAWASAN PROJEK PEMBANGUNAN</td></tr>
        @foreach ($softGroups as $name => $rows)
            @foreach ($rows as $row)
                <tr>
                    @if ($loop->first)
                        <td rowspan="{{ $rows->count() }}">Jenis pokok cadangan<br>({{ $name }})</td>
                    @endif
                    <td style="font-style: italic;">{{ $row->detail }}</td>
                    <td>{{ $n($row->qty) }} {{ $unitLabel($row->unit) }}</td>
                    <td class="right">RM{{ number_format($row->rate, 2) }} X {{ $n($row->qty) }} X {{ $row->months }} bulan = {{ $rm($row->subtotal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Jumlah keseluruhan {{ strtolower($name) }}</td>
                <td class="right">{{ $rm($rows->sum('subtotal')) }}</td>
            </tr>
        @endforeach
        <tr class="bold">
            <td colspan="3">Jumlah Keseluruhan Landskap Lembut (B)</td>
            <td class="right">{{ $rm($calculation->total_b) }}</td>
        </tr>

        {{-- C --}}
        <tr class="gray bold"><td colspan="4">C) LANDSKAP KEJUR</td></tr>
        @forelse ($hardItems as $row)
            <tr>
                @if ($loop->first)
                    <td rowspan="{{ $hardItems->count() }}">Landskap kejur</td>
                @endif
                <td>{{ $loop->iteration }}) {{ $row->detail ? 'Lain-lain (' . $row->detail . ')' : $row->name }}</td>
                <td>{{ $n($row->qty) }} {{ $unitLabel($row->unit) }}</td>
                <td class="right">{{ $rm($row->rate) }} X {{ $n($row->qty) }} = {{ $rm($row->subtotal) }}</td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align:center;">Tiada</td></tr>
        @endforelse
        <tr class="bold">
            <td colspan="3">Jumlah Keseluruhan Landskap Kejur (C)</td>
            <td class="right">{{ $rm($calculation->total_c) }}</td>
        </tr>

        <tr class="bold" style="background: #f0fdf4;">
            <td colspan="3">
                JUMLAH KESELURUHAN (A+B+C)<br>
                <span style="font-weight:400; font-size: 12px;">(Jumlah deposit yang perlu dibayar oleh pemaju)</span>
            </td>
            <td class="right" style="font-size: 1.05em;">{{ $rm($calculation->grand_total) }}</td>
        </tr>
    </table>
</div>
@endsection