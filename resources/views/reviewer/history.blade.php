<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Review | Reviewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

<main class="flex-1 p-6 space-y-6">

    <!-- HEADER -->
    <div class="glass rounded-xl p-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-indigo-300">
                🧾 Riwayat Review
            </h1>
            <p class="text-sm text-slate-400">
                Semua tindakan review yang pernah Anda lakukan
            </p>
        </div>

        <div class="text-sm text-slate-400 text-right">
            {{ now()->format('d M Y') }}<br>
            <span class="text-xs">{{ now()->format('H:i') }}</span>
        </div>
    </div>

    <!-- ===== TOMBOL KEMBALI ===== -->
    <div class="flex justify-end">
        <a href="{{ route('dashboard.reviewer') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                  bg-white/5 border border-white/10
                  text-slate-300 text-sm
                  hover:bg-white/10 hover:text-indigo-300
                  transition">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- TABLE -->
    <section class="glass rounded-xl overflow-hidden">

        <div class="grid grid-cols-12 gap-4 px-6 py-4 text-xs text-slate-400 border-b border-white/10">
            <div class="col-span-3">Judul Dokumen</div>
            <div class="col-span-2">Aksi</div>
            <div class="col-span-4">Catatan Reviewer</div>
            <div class="col-span-3">Waktu Selesai Review</div>
        </div>

        @forelse($reviewLogs as $log)
            <div class="grid grid-cols-12 gap-4 px-6 py-4 text-sm row-hover">

                <!-- JUDUL -->
                <div class="col-span-3 font-medium text-slate-100">
                    {{ $log->pengajuan->judul ?? '-' }}
                </div>

                <!-- AKSI -->
                <div class="col-span-2">
                    @if($log->action === 'approve')
                        <span class="text-green-400 font-medium">Approved</span>
                    @elseif($log->action === 'reject')
                        <span class="text-red-400 font-medium">Rejected</span>
                    @else
                        <span class="text-yellow-300 font-medium">Revisi</span>
                    @endif
                </div>

                <!-- CATATAN -->
                <div class="col-span-4 text-slate-300">
                    @if($log->note)
                        <p class="text-sm leading-relaxed">
                            {{ $log->note }}
                        </p>
                    @else
                        <span class="italic text-slate-500">
                            Tidak ada catatan
                        </span>
                    @endif
                </div>

                <!-- WAKTU -->
                <div class="col-span-3 text-slate-400">
                    {{ optional($log->finished_at)->format('d M Y H:i') ?? '-' }}
                </div>

            </div>
        @empty
            <div class="px-6 py-8 text-center text-slate-400">
                Belum ada riwayat review.
            </div>
        @endforelse


    </section>

    <!-- PAGINATION -->
    <div>
        {{ $reviewLogs->links() }}
    </div>

</main>

</body>
</html>
