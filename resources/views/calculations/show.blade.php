@extends('layouts.main')

@section('content')
@php
    $a = $calculation->greenAreaRate;
    $rm = fn ($v) => 'RM ' . number_format($v, 2);
    $n = fn ($v) => rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.');

    $softTitles = [
        'Pokok Utama' => 'POKOK UTAMA',
        'Palma' => 'POKOK PALMA',
        'Renek Individu' => 'POKOK RENEK INDIVIDU',
        'Renek Kelompok' => 'POKOK RENEK KELOMPOK (M2)',
        'Penutup Bumi' => 'PENUTUP BUMI (M2)',
        'Rumput' => 'RUMPUT (M2)',
    ];
    $order = array_flip(array_keys($softTitles));
    $softGroups = $calculation->items->where('section', 'B')->groupBy('name')
        ->sortBy(fn ($rows, $name) => $order[$name] ?? 99);
    $hardItems = $calculation->items->where('section', 'C')->values();
@endphp

<style>
    .doc { font-family: Arial, Helvetica, sans-serif; color: #111; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .doc .logo { text-align: center; margin-bottom: 10px; }
    .doc .logo img { height: 84px; width: auto; display: inline-block; }
    .doc .banner { background: #77933c; color: #fff; text-align: center; font-weight: 700; font-size: 17px; padding: 8px 10px; margin-bottom: 16px; }
    .doc .jenis { margin-bottom: 16px; font-size: 12.5px; line-height: 1.55; }
    .doc .jenis-label { font-weight: 700; margin-bottom: 3px; }
    .doc table { width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 12.5px; margin-bottom: 14px; }
    .doc td { border: 1px solid #222; padding: 4px 8px; vertical-align: middle; word-wrap: break-word; }
    .doc .sec td { background: #a8c26a; font-weight: 700; }
    .doc .colhead td { background: #e4ecd0; text-align: center; }
    .doc .grp td { background: #f4f7ea; font-weight: 700; border-width: 2px; }
    .doc .b td { font-weight: 700; }
    .doc .c { text-align: center; }
    .doc .r { text-align: right; }
    .doc .sp { font-style: italic; }
    .doc .grand td { background: #f6b53c; font-weight: 700; font-size: 13.5px; }
    .doc .grand .sub { font-size: 11.5px; }

    @page { size: A4; margin: 12mm; }
    @media print {
        nav, header, footer, .no-print { display: none !important; }
        body { background: #fff; }
        main { padding: 0; max-width: none; }
        .doc { padding: 0; box-shadow: none; border: none !important; }
        .doc tr { page-break-inside: avoid; }
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

        <a href="{{ route('calculations.edit', $calculation) }}"
           class="btn btn-blue btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit
        </a>

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

    <div class="logo">
        <img src="{{ asset('images/logo-mdht.png') }}" alt="Logo MDHT">
    </div>

    <div class="banner">PENGIRAAN DEPOSIT PENYELENGGARAAN LANDSKAP</div>

    <div class="jenis">
        <div class="jenis-label">JENIS PEMBANGUNAN :</div>
        <div>{{ mb_strtoupper($calculation->development_type) }}</div>
    </div>

    {{-- A --}}
    <table>
        <colgroup><col style="width:80%"><col style="width:20%"></colgroup>
        <tr class="sec"><td colspan="2">A) KAWASAN HIJAU – merangkumi semua skop pembersihan awam.</td></tr>
        <tr class="colhead"><td>Kategori Pembangunan</td><td>Kadar (RM)</td></tr>
        <tr>
            <td class="c">{{ $a->category }}{{ $a->tier ? ' ' . $a->tier : '' }}</td>
            <td class="r">{{ $rm($calculation->total_a) }}</td>
        </tr>
        <tr class="b">
            <td class="r">Jumlah Keseluruhan Kawasan Hijau (A)</td>
            <td class="r">{{ $rm($calculation->total_a) }}</td>
        </tr>
    </table>

    {{-- B --}}
    <table>
        <colgroup>
            <col style="width:6%"><col style="width:44%"><col style="width:12%"><col style="width:18%"><col style="width:20%">
        </colgroup>
        <tr class="sec"><td colspan="5">B) LANDSKAP LEMBUT</td></tr>
        <tr class="colhead">
            <td>Bil.</td><td>Jenis pokok cadangan</td><td>Bilangan</td><td>Kadar seunit/bulan (RM)</td><td>Jumlah 12 bulan (RM)</td>
        </tr>
        @forelse ($softGroups as $name => $rows)
            <tr class="grp"><td colspan="5">{{ $softTitles[$name] ?? mb_strtoupper($name) }}</td></tr>
            @foreach ($rows as $row)
                <tr>
                    <td class="c">{{ $loop->iteration }}</td>
                    <td class="sp">{{ $row->detail ?: $row->name }}</td>
                    <td class="c">{{ $n($row->qty) }}</td>
                    <td class="r">{{ $rm($row->rate) }}</td>
                    <td class="r">{{ $rm($row->subtotal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="r">JUMLAH :</td>
                <td class="r">{{ $rm($rows->sum('subtotal')) }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="c">Tiada</td></tr>
        @endforelse
        <tr class="b">
            <td colspan="4" class="r">Jumlah keseluruhan Landskap Lembut (B)</td>
            <td class="r">{{ $rm($calculation->total_b) }}</td>
        </tr>
    </table>

    {{-- C --}}
    <table>
        <colgroup>
            <col style="width:6%"><col style="width:44%"><col style="width:12%"><col style="width:18%"><col style="width:20%">
        </colgroup>
        <tr class="sec"><td colspan="5">C) LANDSKAP KEJUR</td></tr>
        <tr class="colhead">
            <td>Bil.</td><td>Komponen landskap kejur</td><td>Kuantiti</td><td>Kadar (RM)</td><td>Jumlah (RM)</td>
        </tr>
        @forelse ($hardItems as $row)
            @php
                $label = ($row->detail ? 'Lain-lain (' . $row->detail . ')' : $row->name)
                    . ($row->unit === 'm2' ? ' (m²)' : '');
            @endphp
            <tr>
                <td class="c">{{ $loop->iteration }}</td>
                <td>{{ $label }}</td>
                <td class="c">{{ $n($row->qty) }}</td>
                <td class="r">{{ $rm($row->rate) }}</td>
                <td class="r">{{ $rm($row->subtotal) }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="c">Tiada</td></tr>
        @endforelse
        @if ($hardItems->count())
            <tr>
                <td colspan="4" class="r">JUMLAH :</td>
                <td class="r">{{ $rm($calculation->total_c) }}</td>
            </tr>
        @endif
        <tr class="b">
            <td colspan="4" class="r">Jumlah keseluruhan Landskap Kejur (C)</td>
            <td class="r">{{ $rm($calculation->total_c) }}</td>
        </tr>
    </table>

    {{-- A+B+C --}}
    <table class="grand">
        <colgroup><col style="width:80%"><col style="width:20%"></colgroup>
        <tr>
            <td class="r">
                JUMLAH KESELURUHAN (A+B+C)<br>
                <span class="sub">(Jumlah deposit yang perlu dibayar oleh pemaju)</span>
            </td>
            <td class="r">{{ $rm($calculation->grand_total) }}</td>
        </tr>
    </table>
</div>
@endsection