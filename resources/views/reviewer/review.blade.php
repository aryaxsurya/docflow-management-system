<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Review Dokumen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

<body class="min-h-screen p-6">

<!-- ================= HEADER ================= -->

<div class="glass rounded-xl p-6 mb-6 relative text-center">

    <a href="{{ route('dashboard.reviewer') }}"
       class="absolute right-6 top-6 text-sm text-indigo-400 hover:text-indigo-300">
        ← Kembali
    </a>

    <h1 class="text-xl font-medium text-slate-400 mb-1">
        📄 Review Dokumen
    </h1>

    <h2 class="text-3xl font-bold text-indigo-300 tracking-wide">
        {{ $pengajuan->judul }}
    </h2>

</div>


<!-- ================= INFO DOKUMEN ================= -->
<div class="glass rounded-xl p-6 mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">

    <div>
        <p class="text-slate-400">Status</p>
        <p class="font-medium text-slate-100">
            {{ strtoupper($pengajuan->status) }}
        </p>
    </div>

    <div>
        <p class="text-slate-400">Deadline Review</p>
        <p class="font-medium text-yellow-300">
            {{ $pengajuan->tanggal_berlaku
                ? $pengajuan->tanggal_berlaku->format('d M Y H:i')
                : '-' }}
        </p>
    </div>

    <div>
        <p class="text-slate-400">Diajukan Oleh</p>
        <p class="font-medium text-slate-100">
            {{ $pengajuan->user?->name ?? '-' }}
        </p>
    </div>

</div>

<!-- ================= DESKRIPSI DOKUMEN ================= -->
<div class="glass rounded-xl p-6 mb-6">

    <h2 class="text-lg font-semibold text-indigo-300 mb-3">
        📝 Deskripsi Dokumen
    </h2>
    @if(!empty($pengajuan->deskripsi))
        <div class="text-slate-300 leading-relaxed">
            {{ $pengajuan->deskripsi }}
        </div>
    @else
        <p class="text-slate-500 italic">
            Tidak ada deskripsi dokumen.
        </p>
    @endif

</div>


<!-- ================= ISI DOKUMEN / PREVIEW ================= -->
<div class="glass rounded-xl p-6 mb-6">

    <h2 class="text-lg font-semibold text-indigo-300 mb-4">
        📄 Isi Dokumen
    </h2>

    @php
        $filePath = $pengajuan->lampiran ?? null;
        $fileType = $filePath
            ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION))
            : null;
    @endphp


    @if(!$filePath)
        <p class="text-slate-500 italic">
            Tidak ada file dokumen.
        </p>

    @elseif($fileType === 'pdf')
        <!-- PDF PREVIEW -->
        <iframe
            src="{{ asset('storage/' . $filePath) }}"
            class="w-full h-[600px] rounded border border-white/10 bg-black"
        ></iframe>

    @elseif($fileType === 'txt')
        <!-- TEXT PREVIEW -->
        <div class="bg-black/40 border border-white/10 rounded p-4
                    text-slate-200 whitespace-pre-line max-h-[500px] overflow-y-auto">
            {{ file_get_contents(storage_path('app/public/' . $filePath)) }}
        </div>

    @elseif($fileType === 'epub')
        <!-- EPUB LIMITED PREVIEW -->
        <div class="bg-black/40 border border-white/10 rounded p-4 text-slate-300">
            <p class="mb-2">
                📘 File EPUB terdeteksi.
            </p>
            <p class="text-sm text-slate-400">
                Preview penuh EPUB tidak didukung langsung.
                Silakan download untuk membaca lengkap.
            </p>
        </div>

    @else
        <p class="text-slate-500 italic">
            Preview tidak tersedia untuk tipe file ini.
        </p>
    @endif

    <!-- ===== DOWNLOAD ===== -->
    <div class="mt-4 flex justify-end">
        <a href="{{ asset('storage/' . $filePath) }}"
           download
           class="inline-flex items-center gap-2 px-4 py-2 rounded
                  bg-indigo-600/20 text-indigo-300 hover:bg-indigo-600/30">
            ⬇️ Download Dokumen
        </a>
    </div>

</div>

<!-- ================= REVIEW LOGS ================= -->
<div class="glass rounded-xl p-6 mb-6">
    <h2 class="text-lg font-semibold text-indigo-300 mb-3">📝 Riwayat Review</h2>

    @if(isset($logs) && $logs->count())
        <div class="space-y-4">
            @foreach($logs as $log)
                @php
                    $action = $log->action;
                    if ($action === 'approve') {
                        $borderClass = 'border-l-4 border-green-500/60';
                        $labelClass = 'text-green-300';
                        $bgClass = 'bg-green-900/5';
                        $actionLabel = 'Disetujui';
                    } elseif ($action === 'request_changes') {
                        $borderClass = 'border-l-4 border-yellow-500/60';
                        $labelClass = 'text-yellow-300';
                        $bgClass = 'bg-yellow-900/5';
                        $actionLabel = 'Diminta Perubahan';
                    } elseif ($action === 'reject') {
                        $borderClass = 'border-l-4 border-red-500/60';
                        $labelClass = 'text-red-300';
                        $bgClass = 'bg-red-900/5';
                        $actionLabel = 'Ditolak';
                    } else {
                        $borderClass = 'border-l-4 border-slate-600/40';
                        $labelClass = 'text-slate-300';
                        $bgClass = 'bg-white/1';
                        $actionLabel = ucfirst($action ?: 'Log');
                    }
                @endphp

                <div class="p-4 rounded-lg {{ $bgClass }} {{ $borderClass }} flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="text-sm font-semibold {{ $labelClass }}">{{ $actionLabel }}</div>
                            <div class="text-xs text-slate-400">oleh {{ $log->reviewer?->name ?? 'Reviewer' }}</div>
                        </div>

                        @if(!empty($log->note))
                            <div class="mt-3 text-slate-100 whitespace-pre-line">{{ $log->note }}</div>
                        @endif
                    </div>

                    <div class="text-right text-xs text-slate-400">
                        <div>{{ $log->finished_at ? $log->finished_at->diffForHumans() : $log->created_at->diffForHumans() }}</div>
                        <div class="text-slate-500 mt-1">{{ ($log->finished_at ?? $log->created_at)->format('d M Y H:i') }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-slate-500 italic">Belum ada catatan review.</p>
    @endif

</div>

    @php
        $user = auth()->user();

        // Ambil angka dari status: Review1 → 1, Review2 → 2
        preg_match('/Review(\d+)/i', $pengajuan->status, $match);
        $activeReviewLevel = $match[1] ?? null;
    @endphp

    @if(
        $user &&
        $activeReviewLevel &&
        (int) $user->reviewer_level === (int) $activeReviewLevel
    )

    <!-- ================= FORM REVIEW ================= -->
    <form method="POST"
        class="glass rounded-xl p-6 space-y-4">
        @csrf

        <!-- CATATAN -->
        <div>
            <label class="block text-sm text-slate-400 mb-1">
                Catatan Reviewer
            </label>
            <textarea
                name="note"
                rows="4"
                class="w-full rounded bg-black/40 border border-white/10
                    text-slate-100 p-3
                    focus:outline-none focus:ring focus:ring-indigo-500/30"
                placeholder="Tulis catatan review (wajib untuk reject & revisi)"
            ></textarea>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex justify-end gap-3">

            <!-- REJECT -->
            <button
                type="submit"
                formaction="{{ route('reviewer.reject', $pengajuan->id) }}"
                onclick="return confirm('Yakin ingin menolak pengajuan ini?')"
                class="px-4 py-2 rounded
                    bg-red-600/20 text-red-400
                    hover:bg-red-600/30 transition">
                ❌ Reject
            </button>

            <!-- REQUEST CHANGES -->
            <button
                type="submit"
                formaction="{{ route('reviewer.request', $pengajuan->id) }}"
                class="px-4 py-2 rounded
                    bg-yellow-600/20 text-yellow-300
                    hover:bg-yellow-600/30 transition">
                🔁 Request Changes
            </button>

            <!-- APPROVE -->
            <button
                type="submit"
                formaction="{{ route('reviewer.approve', $pengajuan->id) }}"
                onclick="return confirm('Setujui pengajuan ini?')"
                class="px-4 py-2 rounded
                    bg-green-600/20 text-green-300
                    hover:bg-green-600/30 transition">
                ✅ Approve
            </button>

        </div>
    </form>




    @endif


</body>
</html>
