@extends('layouts.main')

@section('content')

{{-- Page Header --}}
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('calculations.index') }}"
       class="text-gray-400 hover:text-green-700 transition-colors"
       title="Kembali">
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

<script>
function calcForm(green, soft, hard) {
    return {
        green, soft, hard,
        category: '',
        rateId: '',
        softRows: [],
        hardRows: [],
        get tiers() {
            return this.green.filter(r => r.category === this.category);
        },
        get greenAmount() {
            const r = this.green.find(r => r.id == this.rateId);
            return r ? Number(r.amount) : 0;
        },
        get totalB() {
            return this.softRows.reduce((sum, r) => {
                const item = this.soft[r.rate_id];
                return sum + (item ? Number(item.rate) * Number(r.qty || 0) * 12 : 0);
            }, 0);
        },
        get totalC() {
            return this.hardRows.reduce((sum, r) => {
                const item = this.hard[r.item_id];
                return sum + (item ? Number(item.rate) * Number(r.qty || 0) : 0);
            }, 0);
        },
        fmt(n) {
            return n.toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },
        qtyLabel(map, id) {
            const u = map[id] ? map[id].unit : '';
            if (u === 'm2') return 'Luas (m²)';
            if (u === 'pokok') return 'Bilangan pokok';
            return 'Kuantiti';
        },
        isOther(id) { return !!this.hard[id] && this.hard[id].unit === 'l/s'; },
        addSoft() { this.softRows.push({ key: Math.random(), rate_id: '', detail: '', qty: '' }); },
        addHard() { this.hardRows.push({ key: Math.random(), item_id: '', qty: '', detail: '' }); },
    };
}
</script>

<form method="POST" action="{{ route('calculations.store') }}"
      x-data="calcForm({{ \Illuminate\Support\Js::from($greenRates) }}, {{ \Illuminate\Support\Js::from($softRates->keyBy('id')) }}, {{ \Illuminate\Support\Js::from($hardItems->keyBy('id')) }})"
      x-init="$watch('category', () => { rateId = ''; $nextTick(() => { if (tiers.length === 1) rateId = String(tiers[0].id); }); })"
      class="space-y-6">
    @csrf

    <div class="card space-y-4">
        <h2 class="card-title">Maklumat Projek</h2>
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                Jenis Pembangunan
            </label>
            <input type="text" name="development_type" value="{{ old('development_type') }}" required
                   placeholder="cth: Projek Perumahan 70 Unit Rumah"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
        </div>
    </div>

    {{-- A: Kawasan Hijau --}}
    <div class="card space-y-4">
        <h2 class="card-title">A) Kawasan Hijau</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Kategori</label>
                <select x-model="category" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                    <option value="">— Pilih kategori —</option>
                    @foreach ($greenRates->groupBy('group') as $group => $rates)
                        <optgroup label="{{ $group }}">
                            @foreach ($rates->pluck('category')->unique() as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Kadar</label>
                <select name="green_area_rate_id" x-model="rateId" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                    <option value="">— Pilih —</option>
                    <template x-for="t in tiers" :key="t.id">
                        <option :value="t.id" x-text="(t.tier ?? 'Kadar tetap') + ' — RM ' + Number(t.amount).toLocaleString('en-MY', {minimumFractionDigits: 2})"></option>
                    </template>
                </select>
            </div>
        </div>
        <div class="flex items-center justify-between bg-green-50 rounded-lg px-4 py-2.5 border border-green-100">
            <span class="text-sm text-green-800 font-medium">Jumlah A</span>
            <span class="font-bold text-green-900 text-base">
                RM <span x-text="greenAmount.toLocaleString('en-MY', {minimumFractionDigits: 2})">0.00</span>
            </span>
        </div>
    </div>

    {{-- B: Landskap Lembut --}}
    <div class="card space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="card-title">B) Landskap Lembut</h2>
            <button type="button" @click="addSoft()" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah
            </button>
        </div>
        <template x-for="(row, i) in softRows" :key="row.key">
            <div class="grid grid-cols-12 gap-2 items-center bg-gray-50 rounded-xl p-3 border border-gray-100">
                <select :name="`soft[${i}][rate_id]`" x-model="row.rate_id" required
                        class="col-span-4 border border-gray-200 rounded-lg px-2 py-2 text-sm bg-white">
                    <option value="">— Jenis —</option>
                    @foreach ($softRates as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} (RM {{ number_format($s->rate, 2) }}/{{ $s->unit }})</option>
                    @endforeach
                </select>
                <input type="text" :name="`soft[${i}][detail]`" x-model="row.detail"
                       placeholder="Nama spesies"
                       class="col-span-4 border border-gray-200 rounded-lg px-2 py-2 text-sm bg-white">
                <input type="number" step="0.01" min="0.01" :name="`soft[${i}][qty]`" x-model="row.qty"
                       :placeholder="qtyLabel(soft, row.rate_id)" required
                       class="col-span-3 border border-gray-200 rounded-lg px-2 py-2 text-sm bg-white">
                <button type="button" @click="softRows.splice(i, 1)"
                        class="btn btn-icon col-span-1 justify-self-center" title="Buang">✕</button>
            </div>
        </template>
        <p x-show="softRows.length === 0"
           class="text-sm text-gray-400 text-center py-4 bg-gray-50 rounded-lg border border-dashed border-gray-200">
            Tiada item. Klik <strong>+ Tambah</strong> jika ada.
        </p>
        <div class="flex items-center justify-between bg-green-50 rounded-lg px-4 py-2.5 border border-green-100">
            <span class="text-sm text-green-800 font-medium">Jumlah B</span>
            <span class="font-bold text-green-900 text-base">RM <span x-text="fmt(totalB)">0.00</span></span>
        </div>
    </div>

    {{-- C: Landskap Kejur --}}
    <div class="card space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="card-title">C) Landskap Kejur</h2>
            <button type="button" @click="addHard()" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah
            </button>
        </div>
        <template x-for="(row, i) in hardRows" :key="row.key">
            <div class="grid grid-cols-12 gap-2 items-start bg-gray-50 rounded-xl p-3 border border-gray-100">
                <select :name="`hard[${i}][item_id]`" x-model="row.item_id" required
                        class="col-span-8 border border-gray-200 rounded-lg px-2 py-2 text-sm bg-white">
                    <option value="">— Peralatan —</option>
                    @foreach ($hardItems->groupBy(fn ($h) => $h->group ?? 'Umum') as $group => $items)
                        <optgroup label="{{ $group }}">
                            @foreach ($items as $h)
                                <option value="{{ $h->id }}">{{ $h->name }} (RM {{ number_format($h->rate, 2) }}/{{ $h->unit }})</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <input type="number" step="0.01" min="0.01" :name="`hard[${i}][qty]`" x-model="row.qty"
                       :placeholder="qtyLabel(hard, row.item_id)" required
                       class="col-span-3 border border-gray-200 rounded-lg px-2 py-2 text-sm bg-white">
                <button type="button" @click="hardRows.splice(i, 1)"
                        class="btn btn-icon col-span-1 justify-self-center mt-0.5" title="Buang">✕</button>
                <input type="text" :name="`hard[${i}][detail]`" x-model="row.detail"
                       x-show="isOther(row.item_id)" :required="isOther(row.item_id)"
                       placeholder="Nyatakan (cth: Pondok pengawal)"
                       class="col-span-12 border border-gray-200 rounded-lg px-2 py-2 text-sm bg-white">
            </div>
        </template>
        <p x-show="hardRows.length === 0"
           class="text-sm text-gray-400 text-center py-4 bg-gray-50 rounded-lg border border-dashed border-gray-200">
            Tiada item. Klik <strong>+ Tambah</strong> jika ada.
        </p>
        <div class="flex items-center justify-between bg-green-50 rounded-lg px-4 py-2.5 border border-green-100">
            <span class="text-sm text-green-800 font-medium">Jumlah C</span>
            <span class="font-bold text-green-900 text-base">RM <span x-text="fmt(totalC)">0.00</span></span>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3 pt-2">
        <a href="{{ route('calculations.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary px-8">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            Kira &amp; Simpan
        </button>
    </div>
@endsection