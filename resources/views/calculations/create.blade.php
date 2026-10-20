@extends('layouts.main')

@section('content')

{{-- Page Header --}}
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('calculations.index') }}"
       class="text-gray-400 hover:text-green-700 transition-colors" title="Kembali">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengiraan Baru</h1>
        <p class="text-sm text-gray-500 mt-0.5">Isi butiran projek dan item landskap</p>
    </div>
</div>

@if ($errors->any())
    <div class="flex gap-3 bg-red-50 border border-red-200 border-l-4 border-l-red-500 text-red-800 p-4 rounded-xl mb-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="shrink-0 mt-0.5" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <ul class="list-disc ml-1 space-y-0.5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@include('calculations._form', [
    'formAction' => route('calculations.store'),
    'formMethod' => 'POST',
    'old'        => [
        'development_type'   => old('development_type', ''),
        'green_area_rate_id' => old('green_area_rate_id', ''),
        'category'           => '',
        'rateId'             => old('green_area_rate_id', ''),
        'softRows'           => [],
        'hardRows'           => [],
    ],
])

@endsection