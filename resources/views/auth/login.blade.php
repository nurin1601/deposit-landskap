@extends('layouts.main')

@section('content')
<div style="max-width: 440px; margin: 40px auto;">
    <div class="card">
        <div class="card-title" style="margin-bottom: 16px;">Log Masuk</div>

        @if (session('status'))
            <div class="flash-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">E-mel</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                @error('email')
                    <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Kata laluan</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 focus:bg-white">
                @error('password')
                    <p class="text-sm mt-1" style="color:#dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember"> Ingat saya
            </label>

            <button type="submit" class="btn btn-primary" style="width:100%;">Log Masuk</button>
        </form>
    </div>
</div>
@endsection