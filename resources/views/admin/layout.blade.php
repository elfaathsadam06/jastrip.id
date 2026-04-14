<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-xl fixed inset-y-0 left-0 z-20">

        {{-- LOGO --}}
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-extrabold text-blue-600">
                Jastrip<span class="text-gray-700">Admin</span>
            </h1>
            <p class="text-xs text-gray-500 mt-1">Administrator Panel</p>
        </div>

        {{-- NAV --}}
        <nav class="mt-4 space-y-1 text-sm font-medium text-gray-700">

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-6 py-3 rounded-lg
                hover:bg-blue-50 transition
                {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>

            {{-- USERS --}}
            <a href="{{ route('admin.users') }}"
                class="flex items-center gap-3 px-6 py-3 rounded-lg
                hover:bg-blue-50 transition
                {{ request()->routeIs('admin.users*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Customer
            </a>

            {{-- PESANAN --}}
            <a href="{{ route('admin.pesanan.index') }}"
                class="flex items-center gap-3 px-6 py-3 rounded-lg
                hover:bg-blue-50 transition
                {{ request()->routeIs('admin.pesanan*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2"
                        d="M9 12h6m-6 4h6M7 4h10a2 2
                        0 012 2v12a2 2 0 01-2 2H7a2 2
                        0 01-2-2V6a2 2 0 012-2z"/>
                </svg>
                Pesanan
            </a>

            {{-- PEMBAYARAN --}}
            <a href="{{ route('pembayaran.index') }}"
                class="flex items-center gap-3 px-6 py-3 rounded-lg
                hover:bg-blue-50 transition
                {{ request()->routeIs('pembayaran*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2"
                        d="M2 8h20M2 12h20M4 16h4
                        M2 6a2 2 0 012-2h16a2 2 0
                        012 2v12a2 2 0 01-2 2H4
                        a2 2 0 01-2-2V6z"/>
                </svg>
                Pembayaran
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-4 mt-4 border-t">
                @csrf
                <button
                    class="w-full flex items-center gap-3 px-6 py-3 rounded-lg
                    text-red-600 hover:bg-red-50 transition font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7
                            m6 4v1a2 2 0 01-2 2H5a2 2
                            0 01-2-2V7a2 2 0 012-2h6
                            a2 2 0 012 2v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- CONTENT --}}
    <main class="ml-64 flex-1">

        {{-- TOP BAR --}}
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">
            </h2>

            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Admin
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <section class="p-8">
            @yield('content')
        </section>
    </main>
</div>

</body>
</html>
