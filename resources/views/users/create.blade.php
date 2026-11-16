@extends('layouts.main')

@section('content')
<div style="max-width: 480px; margin: 32px auto;">
    <div class="card">
        <div class="card-title" style="margin-bottom: 16px;">Tambah Pengguna</div>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       placeholder="Masukkan nama pengguna"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                @error('name') <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">E-mel</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="off"
                       placeholder="Masukkan e-mel pengguna"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                @error('email') <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Kata laluan</label>
                <div class="relative" x-data="{ visible: false }" style="position: relative;">
                    <input id="password" :type="visible ? 'text' : 'password'" name="password" required autocomplete="new-password"
                           placeholder="Masukkan kata laluan"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 pr-16 text-sm bg-gray-50 focus:bg-white">
                    <button type="button" @click="visible = !visible" :aria-pressed="visible"
                            :aria-label="visible ? 'Sembunyikan kata laluan' : 'Papar kata laluan'"
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
                @error('password') <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin'))>
                Jadikan admin (boleh urus pengguna)
            </label>

            <div class="flex justify-end gap-3">
                <a href="{{ route('users.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection