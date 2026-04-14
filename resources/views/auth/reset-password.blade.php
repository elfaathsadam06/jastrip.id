<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-96">
    <h2 class="text-xl font-bold mb-4 text-center">Atur Password Baru</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-3">
            <label class="block text-gray-700">Password Baru</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-3">
            <label class="block text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded mt-3 hover:bg-blue-600">
            Simpan Password
        </button>
    </form>
</div>

</body>
</html>
