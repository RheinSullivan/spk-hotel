<x-guest-layout>
    <!-- Header with Image -->
    <div class="flex flex-col items-center mb-6">
        <img src="/assets/Header Login.jpeg" alt="Login Illustration" class="w-90 h-30 mb-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Selamat Datang!</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">Silahkan login terlebih dahulu</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Log in Button -->
        <div class="flex justify-center">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <!-- Link Registrasi -->
<div class="mt-4 text-center">
    <p>Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar di sini</a></p>
</div>
    </form>

    <!-- Register Button -->
    <!-- <div class="flex justify-center mt-4">
        <a href="{{ route('register') }}" class="w-full">
            <x-primary-button class="w-full">
                {{ __('Register') }}
            </x-primary-button>
        </a>
    </div> -->
</x-guest-layout>

