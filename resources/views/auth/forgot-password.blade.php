<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-96">
    <h2 class="text-xl font-bold mb-4 text-center">Reset Password</h2>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded mt-3 hover:bg-blue-600">
            Kirim Link Reset
        </button>
    </form>
</div>

</body>
</html>
