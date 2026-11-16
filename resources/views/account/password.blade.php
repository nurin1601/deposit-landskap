@extends('layouts.main')

@section('content')
<div style="max-width: 480px; margin: 32px auto;">
    <a href="{{ route('calculations.index') }}" class="btn btn-outline btn-sm" style="margin-bottom: 16px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali
    </a>

    <div class="card">
        <div class="card-title" style="margin-bottom: 16px;">Tukar Kata Laluan</div>

        <form method="POST" action="{{ route('account.password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Kata laluan semasa</label>
                <div class="relative" x-data="{ visible: false }" style="position: relative;">
                    <input id="current_password" :type="visible ? 'text' : 'password'" name="current_password" required autocomplete="current-password"
                           placeholder="Masukkan kata laluan semasa"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 pr-16 text-sm bg-gray-50 focus:bg-white">
                    <button type="button" @click="visible = !visible" :aria-pressed="visible"
                            :aria-label="visible ? 'Sembunyikan kata laluan semasa' : 'Papar kata laluan semasa'"
                            class="absolute flex items-center justify-center text-green-700 hover:text-green-900"
                            style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%);">
                        <svg x-show="!visible" aria-hidden="true" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z"/>
                            <path d="m3 3 18 18"/>
                        </svg>
                        <svg x-show="visible" aria-hidden="true" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('current_password') <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Kata laluan baharu</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="Masukkan kata laluan baharu"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                @error('password') <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Sahkan kata laluan baharu</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="Sahkan kata laluan baharu"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                @error('password_confirmation') <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Kata Laluan</button>
        </form>
    </div>
</div>
@endsection