<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - BukuUsaha</title>
    <!-- Load Tailwind CSS melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Sisi Kiri: Ilustrasi & Informasi (Hanya muncul di layar besar) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-900 to-slate-900 justify-center items-center p-12 relative overflow-hidden">
            <!-- Ornamen Background -->
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-slate-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            
            <div class="max-w-md text-center lg:text-left z-10">
                <h1 class="text-4xl font-extrabold text-white tracking-tight leading-none mb-6">
                    BukuUsaha
                </h1>
                <p class="text-lg text-indigo-200 mb-8 leading-relaxed">
                    Mulai langkah awal digitalisasi operasional usaha Anda. Catat setiap transaksi secara sistematis untuk memantau perkembangan keuntungan secara nyata.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm text-slate-300">Pendaftaran mudah tanpa biaya administrasi.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm text-slate-300">Mendukung multi-user dengan hak akses terproteksi.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Register -->
        <div class="flex-1 flex items-center justify-center p-8 sm:p-12 lg:w-1/2 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                        Buat Akun Baru
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Isi data berikut untuk mulai mengelola pencatatan keuangan.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                        <input id="name" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                        <input id="email" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                        <input id="password" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Daftarkan Akun
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-slate-600">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">
                        Masuk di Sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>