<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reviewer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(180deg, #0a0f1f, #020617);
            color: #e5e7eb;
        }
        .glass {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="min-h-screen">

<!-- ================= HEADER ================= -->
<header class="glass px-6 py-4 flex justify-between items-center">
    <div>
        <h1 class="text-xl font-semibold text-indigo-300">
            Reviewer Dashboard
        </h1>
        <p class="text-sm text-slate-400">
            Selamat datang,
            <span class="font-medium text-slate-200">
                {{ $reviewerName ?? optional(auth()->user())->name ?? 'Reviewer' }}
            </span>
        </p>
    </div>

    <!-- KANAN: TANGGAL + LOGOUT -->
    <div class="flex items-center gap-6 text-sm">

        <!-- Tanggal & Jam -->
        <div class="text-right">
            <p class="text-slate-300 font-medium">
                {{ now()->format('l, d M Y') }}
            </p>
            <p class="text-slate-400 text-xs">
                {{ now()->format('H:i') }} WIB
            </p>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-400 hover:text-red-500 font-medium">
                Logout
            </button>
        </form>

    </div>
</header>


<!-- ================= BODY ================= -->
<div class="flex">

    <!-- ========== SIDEBAR ========== -->
    <aside class="w-64 min-h-screen px-4 py-6 glass">
        <nav class="space-y-2 text-sm">

            <a href="{{ route('dashboard.reviewer') }}"
               class="block px-3 py-2 rounded bg-indigo-600/20 text-indigo-300 font-medium">
                📊 Dashboard
            </a>

            <a href="{{ route('reviewer.deadlines') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('reviewer.deadlines')
                    ? 'bg-indigo-600/20 text-indigo-300 font-medium'
                    : 'hover:bg-white/5 text-slate-300' }}">
                ⏰ Cek Deadline
            </a>

            <a href="{{ route('reviewer.reviews.index') }}"
                class="block px-3 py-2 rounded {{ request()->routeIs('reviewer.reviews.*')
                ? 'bg-indigo-600/20 text-indigo-300 font-medium'
                : 'hover:bg-white/5 text-slate-300' }}">
                📥 Daftar Seluruh Dokumen
            </a>

            <a href="{{ route('reviewer.history') }}"
            class="block px-3 py-2 rounded
            {{ request()->routeIs('reviewer.history')
                    ? 'bg-indigo-600/20 text-indigo-300 font-medium'
                    : 'hover:bg-white/5 text-slate-300' }}">
                🧾 Riwayat Review
            </a>

        </nav>
    </aside>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1 p-6 space-y-6">

        <!-- ===== RINGKASAN ===== -->
    <section class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="glass rounded-xl p-5 border border-blue-500/20">
            <h3 class="text-sm text-slate-400">
                Menunggu Review
            </h3>
            <p class="text-3xl font-semibold text-indigo-300">
                {{ $pendingReviews }}
            </p>
        </div>

        <div class="glass rounded-xl p-5 border border-yellow-500/20">
            <h3 class="text-sm text-slate-400">
                Hampir Deadline
            </h3>
            <p class="text-3xl font-semibold text-yellow-400">
                {{ $nearDeadline }}
            </p>
        </div>

        <!-- 🔥 BARU -->
        <div class="glass rounded-xl p-5 border border-red-500/20">
            <h3 class="text-sm text-slate-400">
                Lewat Deadline
           </h3>
            <p class="text-3xl font-semibold text-red-400">
                {{ $overdueCount }}
            </p>
        </div>

        <div class="glass rounded-xl p-5 border border-green-500/20">
            <h3 class="text-sm text-slate-400">
                Sudah Direview
            </h3>
            <p class="text-3xl font-semibold text-green-400">
                {{ $completedCount }}
            </p>
        </div>

    </section>


        <!-- ===== DAFTAR DOKUMEN ===== -->
        <section class="glass rounded-xl overflow-hidden">

        <div class="border-b border-white/10 px-6 py-4">
            <h2 class="text-lg font-semibold text-blue-300">
                Dokumen Menunggu Review Anda
            </h2>
            <p class="text-sm text-slate-400">
                Prioritaskan dokumen dengan deadline terdekat
            </p>
        </div>

        <div class="divide-y divide-white/5">

            @forelse($latestPengajuan as $pengajuan)
                <div class="px-6 py-4 flex justify-between items-center hover:bg-white/5 transition">

                    <div>
                        <h3 class="font-medium text-slate-100">
                            {{ $pengajuan->judul }}
                        </h3>
                    </div>

                    <div class="text-right text-sm">
                        <p class="text-slate-400">
                            Deadline:
                            @if($pengajuan->tanggal_berlaku)

                                @php
                                    $now = now();
                                    $deadline = $pengajuan->tanggal_berlaku;
                                    $daysLeft = (int) $now->diffInDays($deadline, false);
                                @endphp

                                @if($daysLeft < 0)
                                    <span class="text-red-400 font-semibold">
                                        {{ $deadline->format('d M Y H:i') }} (Lewat Deadline)
                                    </span>
                                @elseif($daysLeft <= 7)
                                    <span class="text-yellow-300 font-medium">
                                        {{ $deadline->format('d M Y H:i') }} ({{ $daysLeft }} hari lagi)
                                    </span>
                                @else
                                    <span class="text-blue-400">
                                        {{ $deadline->format('d M Y H:i') }}
                                    </span>
                                @endif

                            @else
                                <span class="italic text-slate-500">-</span>
                            @endif
                        </p>
                        <a
                            href="{{ route('reviewer.show', $pengajuan->id) }}"
                            class="inline-block mt-1 text-indigo-400 hover:text-indigo-300"
                        >
                            Review Sekarang →
                        </a>
                    </div>

                </div>
            @empty
                <div class="px-6 py-6 text-center text-slate-400">
                    Tidak ada dokumen yang menunggu review.
                </div>
            @endforelse

        </div>
        </section>


    </main>
</div>

</body>
</html>
