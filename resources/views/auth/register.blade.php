<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Jastrip.id</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-96">
    {{-- Logo / Judul --}}
    <div class="text-center mb-4">
        <h1 class="text-3xl font-bold text-blue-600 mb-2">Jastrip.id</h1>
        <h2 class="text-xl font-semibold">Daftar Akun Baru</h2>
        <p class="text-gray-500 text-sm mt-1">
            Bergabunglah dengan <strong>Jastrip.id</strong> dan nikmati kemudahan layanan transkripsi!
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nama Lengkap --}}
        <div class="mb-3">
            <label class="block text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full border rounded px-3 py-2">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="block text-gray-700">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
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

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
            <label class="block text-gray-700">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required
                class="w-full border rounded px-3 py-2">
        </div>

        {{-- Role otomatis customer --}}
        <input type="hidden" name="role" value="customer">

        {{-- Tombol Daftar --}}
        <button type="submit"
            class="bg-blue-500 text-white w-full py-2 rounded mt-3 hover:bg-blue-600">
            Daftar Sekarang
        </button>

        {{-- Link Login --}}
        <p class="mt-4 text-sm text-center">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-500">Masuk di sini</a>
        </p>
    </form>
</div>

</body>
</html>
