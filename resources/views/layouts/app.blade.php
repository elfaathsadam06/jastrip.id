<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jastrip.id')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background-color: #f5f9ff;
            color: #333;
        }

        /* ===== HEADER ===== */
        header {
            background: linear-gradient(90deg, #007bff, #4db8ff);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            flex-wrap: wrap;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-left img {
            height: 46px;
            border-radius: 8px;
            background: white;
            box-shadow: 0 0 5px rgba(0,0,0,0.15);
        }

        .header-left h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
        }

        /* ===== NAVBAR ===== */
        nav {
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        nav a,
        nav button {
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 15px;
        }

        nav a:hover,
        nav button:hover,
        nav a.active {
            color: #002b80;
            transform: translateY(-1px);
        }

        /* ===== MAIN ===== */
        main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 25px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            min-height: 70vh;
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 25px;
            background: #eaf4ff;
            color: #555;
            font-size: 14px;
            border-top: 1px solid #cce2f6;
        }

        footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            nav {
                margin-top: 10px;
                gap: 15px;
                flex-wrap: wrap;
            }

            main {
                margin: 20px 10px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
<header>
    <div class="header-left">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Jastrip">
        <h1>Jastrip.id</h1>
    </div>

<nav>
    {{-- 🔹 Jika user belum login --}}
    @guest
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ url('/#layanan') }}">Layanan</a>
        <a href="{{ url('/#harga') }}">Harga</a>
        <a href="{{ url('/#testimoni') }}">Testimoni</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Daftar</a>
    @endguest

    {{-- 🔹 Jika user sudah login --}}
    @auth
        @if(auth()->user()->role === 'customer')
            <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('pemesanan.create') }}" class="{{ request()->routeIs('pemesanan.create') ? 'active' : '' }}">Pemesanan</a>
            <a href="{{ url('/#harga') }}">Harga</a>
            <a href="{{ url('/#testimoni') }}">Testimoni</a>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">Profil</a>

        @elseif(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard Admin</a>

        @elseif(auth()->user()->role === 'transkriptor')
            <a href="{{ route('transkriptor.dashboard') }}" class="{{ request()->routeIs('transkriptor.dashboard') ? 'active' : '' }}">Dashboard Transkriptor</a>

        @elseif(auth()->user()->role === 'owner')
            <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">Dashboard Owner</a>
        @endif

        {{-- 🔹 Tombol Logout --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endauth
</nav>

</header>

<main>
    @yield('content')
</main>

<footer>
    <p style="display:flex; justify-content:center; align-items:center; gap:16px; flex-wrap:wrap;">
        <!-- Phone (Heroicons) -->
        <span style="display:flex; align-items:center; gap:6px;">
            <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97c.36-.27.527-.734.417-1.173L6.713 3.102A1.125 1.125 0 005.622 2.25H4.25A2.25 2.25 0 002.25 4.5v2.25z" />
            </svg>
            <span>+62 857-1850-1534</span>
        </span>

        <!-- Instagram (Brand SVG) -->
        <span style="display:flex; align-items:center; gap:6px;">
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 width="18" height="18">
                <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10z"/>
                <path d="M12 7a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6z"/>
                <circle cx="17.5" cy="6.5" r="1.5"/>
            </svg>
            <a href="https://instagram.com/jastrip.id" target="_blank">
                @jastrip.id
            </a>
        </span>
    </p>

    <p>&copy; {{ date('Y') }} Jastrip.id. All Rights Reserved.</p>
</footer>
</body>
</html>
