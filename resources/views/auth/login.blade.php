<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - BukuUsaha</title>
    <!-- Load Tailwind CSS melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Sisi Kiri (Ilustrasi) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-900 to-slate-900 justify-center items-center p-12 relative overflow-hidden">
            <!-- Ornamen Background -->
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-slate-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            
            <div class="max-w-md text-center lg:text-left z-10">
                <h1 class="text-4xl font-extrabold text-white tracking-tight leading-none mb-6">
                    BukuUsaha
                </h1>
                <p class="text-lg text-indigo-200 mb-8 leading-relaxed">
                    Selamat datang kembali. Pantau terus arus kas, kelola pengeluaran, dan tingkatkan keuntungan usaha Anda hari ini.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="flex-1 flex items-center justify-center p-8 sm:p-12 lg:w-1/2 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                        Masuk ke Akun
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Masukkan email dan kata sandi Anda untuk melanjutkan.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                        <input id="email" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                        <input id="password" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Lupa Sandi -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <label for="remember_me" class="ml-2 block text-sm text-slate-700">
                                Ingat Saya
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Lupa kata sandi?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Masuk
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-slate-600">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">
                        Daftar di Sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>