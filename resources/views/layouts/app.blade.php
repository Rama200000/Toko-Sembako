<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Toko Sembako' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sora: ['Sora', 'sans-serif'],
                    },
                    boxShadow: {
                        soft: '0 10px 30px rgba(15, 23, 42, 0.08)',
                        deep: '0 20px 50px rgba(67, 56, 202, 0.30)',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes softFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes bobFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes navShimmer {
            0% { transform: translateX(-120%); }
            100% { transform: translateX(120%); }
        }

        .motion-nav {
            position: relative;
            isolation: isolate;
        }

        .motion-nav::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 0%, rgba(255, 255, 255, 0.18) 45%, transparent 75%);
            pointer-events: none;
            animation: navShimmer 9s linear infinite;
            z-index: 0;
        }

        .motion-nav > * {
            position: relative;
            z-index: 1;
        }

        .blob-a,
        .blob-b {
            animation: softFloat 6s ease-in-out infinite;
        }

        .blob-b {
            animation-delay: 1.2s;
        }

        .floating {
            animation: bobFloat 4.8s ease-in-out infinite;
            will-change: transform;
        }

        .floating-slow {
            animation-duration: 6.2s;
        }

        .float-delay-1 {
            animation-delay: 0.6s;
        }

        .float-delay-2 {
            animation-delay: 1.2s;
        }

        main > * {
            opacity: 0;
            animation: fadeSlideUp 0.55s ease forwards;
        }

        main > *:nth-child(2) { animation-delay: 0.06s; }
        main > *:nth-child(3) { animation-delay: 0.12s; }
        main > *:nth-child(4) { animation-delay: 0.18s; }
        main > *:nth-child(5) { animation-delay: 0.24s; }
        main > *:nth-child(6) { animation-delay: 0.30s; }

        a,
        button {
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease, background-color 0.2s ease;
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
<body class="min-h-screen bg-[radial-gradient(circle_at_top_right,_#f5f3ff_0%,_#f8fafc_38%,_#ede9fe_100%)] text-slate-800 font-sora">
    <nav class="motion-nav relative overflow-hidden bg-gradient-to-r from-[#312e81] via-[#5b21b6] to-[#6d28d9] text-white shadow-deep sticky top-0 z-30">
        <div class="blob-a absolute -top-12 left-1/4 h-40 w-40 rounded-full bg-white/20 blur-2xl"></div>
        <div class="blob-b absolute -bottom-16 right-0 h-48 w-48 rounded-full bg-violet-200/30 blur-2xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <div>
                <h1 class="font-extrabold tracking-tight text-xl md:text-2xl">Toko Sembako</h1>
                <p class="text-xs text-violet-50/95">Belanja kebutuhan harian untuk rumah dan warung</p>
            </div>
            <div class="hidden md:flex items-center text-xs text-violet-100/95">
                {{ now()->format('d M Y, H:i') }} WIB
            </div>
        </div>

        <div class="relative border-t border-white/20 bg-indigo-950/20">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-2 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none]">
                    <a href="{{ route('home') }}" class="whitespace-nowrap rounded-2xl px-4 py-2 text-sm border transition font-semibold {{ request()->routeIs('home') || request()->routeIs('shop.home') ? 'bg-violet-50 text-violet-800 border-violet-200 shadow' : 'bg-white/10 border-white/30 hover:bg-white/20 text-violet-50' }}">
                        Beranda Shop
                    </a>
                    <a href="{{ route('shop.categories') }}" class="whitespace-nowrap rounded-2xl px-4 py-2 text-sm border transition font-semibold {{ request()->routeIs('shop.categories') ? 'bg-violet-50 text-violet-800 border-violet-200 shadow' : 'bg-white/10 border-white/30 hover:bg-white/20 text-violet-50' }}">
                        Kategori
                    </a>
                    <a href="{{ route('shop.cart') }}" class="whitespace-nowrap rounded-2xl px-4 py-2 text-sm border transition font-semibold {{ request()->routeIs('shop.cart') ? 'bg-violet-50 text-violet-800 border-violet-200 shadow' : 'bg-white/10 border-white/30 hover:bg-white/20 text-violet-50' }}">
                        Keranjang
                    </a>
                    <a href="{{ route('shop.orders') }}" class="whitespace-nowrap rounded-2xl px-4 py-2 text-sm border transition font-semibold {{ request()->routeIs('shop.orders') ? 'bg-violet-50 text-violet-800 border-violet-200 shadow' : 'bg-white/10 border-white/30 hover:bg-white/20 text-violet-50' }}">
                        Pesanan Saya
                    </a>
                    <a href="{{ route('admin.login.form') }}" class="ml-auto whitespace-nowrap text-xs md:text-sm rounded-2xl border border-white/40 bg-white/15 px-4 py-2 hover:bg-white/25 transition font-semibold text-violet-50">
                        Login Admin
                    </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-4 md:p-6">
        <main class="space-y-6">
            @if (session('success'))
                <div class="mb-4 rounded-xl bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 shadow-sm">
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
    </div>
</body>
</html>
