<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk Akun - Jastrip.id</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-96">
    {{-- Logo / Judul --}}
    <div class="text-center mb-4">
        <h1 class="text-3xl font-bold text-blue-600 mb-2">Jastrip.id</h1>
        <h2 class="text-xl font-semibold">Masuk ke Akun Anda</h2>
        <p class="text-gray-500 text-sm mt-1">
            Selamat datang kembali di <strong>Jastrip.id</strong>!
            Silakan login untuk melanjutkan pemesanan transkripsi Anda.
        </p>
    </div>

    {{-- Pesan sukses dari register --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="block text-gray-700">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border rounded px-3 py-2">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="block text-gray-700">Kata Sandi</label>
            <input type="password" name="password" required
                class="w-full border rounded px-3 py-2">
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lupa Password --}}
        <div class="flex items-center justify-between mt-2">
            <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">Lupa password?</a>
        </div>

        {{-- Tombol Login --}}
        <button type="submit"
            class="bg-blue-500 text-white w-full py-2 rounded mt-4 hover:bg-blue-600 transition">
            Masuk Sekarang
        </button>

        {{-- Link ke Register --}}
        <p class="mt-4 text-sm text-center">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar di sini</a>
        </p>
    </form>
</div>

</body>
</html>
