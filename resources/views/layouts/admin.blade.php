<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Toko Sembako' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes navShimmer {
            0% { transform: translateX(-120%); }
            100% { transform: translateX(120%); }
        }

        @keyframes bobFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        .motion-nav {
            position: relative;
            isolation: isolate;
        }

        .motion-nav::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 0%, rgba(255, 255, 255, 0.14) 45%, transparent 78%);
            pointer-events: none;
            animation: navShimmer 8.5s linear infinite;
            z-index: 0;
        }

        .motion-nav > * {
            position: relative;
            z-index: 1;
        }

        .floating {
            animation: bobFloat 5s ease-in-out infinite;
            will-change: transform;
        }

        .floating-slow {
            animation-duration: 6.4s;
        }

        .float-delay-1 {
            animation-delay: 0.6s;
        }

        .float-delay-2 {
            animation-delay: 1.2s;
        }

        main > * {
            opacity: 0;
            animation: fadeSlideUp 0.5s ease forwards;
        }

        main > *:nth-child(2) { animation-delay: 0.06s; }
        main > *:nth-child(3) { animation-delay: 0.12s; }
        main > *:nth-child(4) { animation-delay: 0.18s; }

        a,
        button {
            transition: transform 0.2s ease, opacity 0.2s ease, background-color 0.2s ease;
        }

        a:hover,
        button:hover {
            transform: translateY(-1px);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-rose-50 text-slate-800">
    <nav class="motion-nav bg-gradient-to-r from-pink-700 via-fuchsia-700 to-rose-700 text-white sticky top-0 z-30 shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-3">
            <div>
                <h1 class="text-lg font-bold tracking-wide">Admin Toko Sembako</h1>
                <p class="text-xs text-pink-100">Panel kelola data dan transaksi</p>
            </div>
            <div class="hidden md:flex items-center text-xs text-pink-100">
                {{ now()->format('d M Y, H:i') }} WIB
            </div>
        </div>
        <div class="border-t border-white/20 bg-black/10">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-2 overflow-x-auto">
                <a href="{{ route('admin.dashboard') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm border transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-fuchsia-800 border-white' : 'bg-white/10 border-white/30 hover:bg-white/20' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm border transition {{ request()->routeIs('admin.products.*') ? 'bg-white text-fuchsia-800 border-white' : 'bg-white/10 border-white/30 hover:bg-white/20' }}">Produk</a>
                <a href="{{ route('admin.sales.index') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm border transition {{ request()->routeIs('admin.sales.*') ? 'bg-white text-fuchsia-800 border-white' : 'bg-white/10 border-white/30 hover:bg-white/20' }}">Penjualan</a>
                <a href="{{ route('home') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm border bg-white/10 border-white/30 hover:bg-white/20">Lihat Web Pembeli</a>
                <form method="POST" action="{{ route('admin.logout') }}" class="ml-auto">
                    @csrf
                    <button class="whitespace-nowrap rounded-lg px-3 py-2 text-sm border bg-pink-600 border-pink-500 hover:bg-pink-500">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-4 md:p-6 space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-fuchsia-100 border border-fuchsia-300 text-fuchsia-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3">
                <p class="font-semibold mb-1">Ada kesalahan input:</p>
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
