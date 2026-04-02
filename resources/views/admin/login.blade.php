<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-pink-700 via-fuchsia-700 to-rose-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <p class="text-xs uppercase tracking-[0.2em] text-fuchsia-500">Admin Area</p>
        <h1 class="text-2xl font-bold text-slate-800 mt-1">Login Admin</h1>
        <p class="text-sm text-slate-500 mt-1">Masuk untuk mengelola produk dan transaksi.</p>

        @if (session('success'))
            <div class="mt-4 rounded-xl bg-fuchsia-100 border border-fuchsia-300 text-fuchsia-800 px-3 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 rounded-xl bg-rose-100 border border-rose-300 text-rose-800 px-3 py-2 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="mt-4 space-y-3">
            @csrf
            <input type="text" name="username" value="{{ old('username') }}" placeholder="Username admin" class="w-full rounded-xl border border-slate-300 px-3 py-2" required>
            <input type="password" name="password" placeholder="Password admin" class="w-full rounded-xl border border-slate-300 px-3 py-2" required>
            <button class="w-full rounded-xl bg-fuchsia-700 text-white py-2.5 font-semibold hover:bg-fuchsia-600">Masuk</button>
        </form>

        <p class="text-xs text-slate-500 mt-4">Default: username <strong>admin</strong>, password <strong>admin12345</strong> (bisa diubah via .env).</p>
    </div>
</body>
</html>
