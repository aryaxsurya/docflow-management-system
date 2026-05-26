<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Deadline | Reviewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #0a1124;
            color: #e6eeff;
        }

        .glass {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.12);
        }

        .row-hover:hover {
            background: rgba(255,255,255,0.05);
        }
    </style>
</head>

<body class="min-h-screen flex">

<!-- ========== SIDEBAR ========== -->
<aside class="w-64 min-h-screen px-4 py-6 glass">
    <h2 class="text-xl font-bold text-indigo-300 mb-6">
        🕵️ Reviewer Panel
    </h2>

    <nav class="space-y-2 text-sm">
        <a href="{{ route('dashboard.reviewer') }}"
           class="block px-3 py-2 rounded hover:bg-white/5 text-slate-300">
            📊 Dashboard
        </a>

        <a href="{{ route('reviewer.deadlines') }}"
           class="block px-3 py-2 rounded bg-indigo-600/20 text-indigo-300 font-medium">
            ⏰ Cek Deadline
        </a>

        <a href="{{ route('reviewer.reviews.index') }}"
           class="block px-3 py-2 rounded hover:bg-white/5 text-slate-300">
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

    <!-- ===== HEADER ===== -->
    <div class="glass rounded-xl p-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-indigo-300">
                ⏰ Cek Deadline Dokumen
            </h1>
            <p class="text-sm text-slate-400">
                Dokumen dengan batas waktu aktif
            </p>
        </div>

        <!-- KANAN: Tanggal & Logout -->
        <div class="flex items-center gap-4 text-sm">
        <!-- Tanggal & Jam -->
        <div class="text-slate-400 text-right leading-tight">
            <div class="font-medium text-slate-300">
                {{ now()->format('d M Y') }}
            </div>
            <div class="text-xs">
                {{ now()->format('H:i') }} WIB
            </div>
        </div>

        <!-- Divider tipis -->
        <div class="h-6 w-px bg-white/10"></div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-red-400 hover:text-red-500 font-medium">
                Logout
            </button>
        </form>
        </div>
    </div>


    <!-- ===== LIST DEADLINE ===== -->
    <section class="glass rounded-xl overflow-hidden">

        <!-- Header tabel -->
        <div class="grid grid-cols-12 gap-4 px-6 py-4 text-xs text-slate-400 border-b border-white/10">
            <div class="col-span-4">Judul</div>
            <div class="col-span-3">Unit</div>
            <div class="col-span-3">Deadline</div>
            <div class="col-span-2 text-right">Aksi</div>
        </div>

        @forelse($pengajuanList as $p)
            <div class="grid grid-cols-12 gap-4 px-6 py-4 text-sm row-hover transition">

                <!-- Judul -->
                <div class="col-span-4 font-medium text-slate-100">
                    {{ $p->judul }}
                </div>

                <!-- Unit -->
                <div class="col-span-3 text-slate-400">
                    {{ $p->unit_kerja }}
                </div>

                <!-- Deadline -->
                <div class="col-span-3">
                    @if($p->tanggal_berlaku)
                        @php
                            $daysLeft = (int) now()->diffInDays($p->tanggal_berlaku, false);
                        @endphp

                        @if($daysLeft < 0)
                            <span class="text-red-400 font-semibold">
                                {{ $p->tanggal_berlaku->format('d M Y H:i') }}
                                (Terlambat)
                            </span>
                        @elseif($daysLeft <= 7)
                            <span class="text-yellow-300">
                                {{ $p->tanggal_berlaku->format('d M Y H:i') }}
                                ({{ $daysLeft }} hari lagi)
                            </span>
                        @else
                            <span class="text-blue-400">
                                {{ $p->tanggal_berlaku->format('d M Y H:i') }}
                            </span>
                        @endif
                    @else
                        <span class="italic text-slate-500">-</span>
                    @endif
                </div>

                <!-- Aksi -->
                <div class="col-span-2 text-right">
                    <a href="{{ route('reviewer.review.show', $p->id) }}"
                       class="text-indigo-400 hover:text-indigo-300">
                        Review →
                    </a>
                </div>

            </div>
        @empty
            <div class="px-6 py-8 text-center text-slate-400">
                Tidak ada data deadline.
            </div>
        @endforelse

    </section>

    <!-- ===== PAGINATION ===== -->
    <div>
        {{ $pengajuanList->links() }}
    </div>

</main>

</body>
</html>
