@extends('layouts.main')

@section('content')
<div class="flex items-center justify-between gap-4 flex-wrap mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Urus Pengguna</h1>
        <p class="text-sm text-gray-500">Akaun yang boleh log masuk ke sistem</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Tambah Pengguna</a>
</div>

@if ($errors->any())
    <div class="mb-4 p-3 rounded-lg text-sm" style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca;">
        {{ $errors->first() }}
    </div>
@endif

<div class="card overflow-x-auto" style="padding:0;">
    <table class="w-full text-sm">
        <thead class="bg-green-800 text-white text-left">
            <tr>
                <th class="px-5 py-3">Nama</th>
                <th class="px-5 py-3">E-mel</th>
                <th class="px-5 py-3">Peranan</th>
                <th class="px-5 py-3 text-right">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-5 py-3.5 font-semibold">{{ $u->name }}</td>
                    <td class="px-5 py-3.5">{{ $u->email }}</td>
                    <td class="px-5 py-3.5">{{ $u->is_admin ? 'Admin' : 'Pengguna' }}</td>
                    <td class="px-5 py-3.5 text-right">
                        @if ($u->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $u) }}" style="display:inline;"
                                  data-confirm-delete
                                  data-title="Padam akaun ini?"
                                  data-message="Akaun {{ $u->email }} akan dipadam.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Padam</button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400">Akaun anda</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection