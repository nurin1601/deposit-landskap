<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-lg font-bold text-gray-800 mb-6">Log Masuk</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                E-mel
            </label>
            <x-text-input id="email"
                class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-green-500 focus:ring-green-200"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                Kata Laluan
            </label>
            <x-text-input id="password"
                class="block w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-green-500 focus:ring-green-200"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                       name="remember">
                <span class="text-sm text-gray-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-green-700 hover:text-green-900 font-medium underline underline-offset-2"
                   href="{{ route('password.request') }}">
                    Lupa kata laluan?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl font-semibold text-white text-sm
                       bg-gradient-to-r from-green-600 to-green-800
                       hover:from-green-700 hover:to-green-900
                       shadow-md hover:shadow-lg transition-all duration-200">
            Log Masuk
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
        </button>
    </form>
</x-guest-layout>
