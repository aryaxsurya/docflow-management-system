<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Dokumen | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #0a1124; color: #e6eeff; }
        .glass { background: rgba(255,255,255,0.06); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body class="min-h-screen flex">

    @include('admin.sidebar')

    <div class="flex-1 flex flex-col">
        @include('admin.topbar')

        <main class="p-8 space-y-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-purple-300">{{ $pengajuan->judul }}</h1>
                    <p class="text-purple-200 text-sm mt-2">Detail dokumen dan riwayat review admin.</p>
                </div>

                <a href="{{ url()->previous() }}"
                   class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/15 text-sm">
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <section class="xl:col-span-2 glass rounded-2xl p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-purple-300">Pengaju</p>
                            <p class="mt-1 font-medium">{{ $pengajuan->user->name ?? 'Tidak diketahui' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-300">Status</p>
                            <p class="mt-1 font-medium uppercase">{{ $pengajuan->status }}</p>
                        </div>
                        <div>
                            <p class="text-purple-300">Jenis</p>
                            <p class="mt-1 font-medium">{{ $pengajuan->jenis ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-300">Unit Kerja</p>
                            <p class="mt-1 font-medium">{{ $pengajuan->unit_kerja ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-300">Tanggal Berlaku</p>
                            <p class="mt-1 font-medium">{{ $pengajuan->tanggal_berlaku?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-300">Level Reviewer Aktif</p>
                            <p class="mt-1 font-medium">{{ $pengajuan->current_reviewer_level ?? '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-purple-300 text-sm">Deskripsi</p>
                        <div class="mt-2 p-4 rounded-xl bg-black/20 text-sm leading-7 text-slate-200">
                            {{ $pengajuan->deskripsi ?: 'Tidak ada deskripsi.' }}
                        </div>
                    </div>

                    <div>
                        <p class="text-purple-300 text-sm mb-2">Lampiran</p>
                        @if($pengajuan->lampiran)
                            <a href="{{ asset('storage/' . $pengajuan->lampiran) }}"
                               target="_blank"
                               class="inline-flex px-4 py-2 rounded-lg bg-blue-600/20 text-blue-300 hover:bg-blue-600/30">
                                Lihat Lampiran
                            </a>
                        @else
                            <p class="text-sm text-slate-400">Tidak ada lampiran.</p>
                        @endif
                    </div>
                </section>

                <aside class="glass rounded-2xl p-6 space-y-6">
                    <div>
                        <h2 class="text-lg font-semibold text-purple-300">Aksi Admin</h2>
                        <p class="text-sm text-slate-400 mt-1">Tindak lanjut untuk dokumen yang sudah masuk tahap admin.</p>
                    </div>

                    @if($pengajuan->status === 'approved')
                        <div class="space-y-3">
                            <form method="POST" action="{{ route('admin.documents.approve', $pengajuan->id) }}">
                                @csrf
                                <button type="submit"
                                        class="w-full px-4 py-3 rounded-xl bg-green-600/20 text-green-300 hover:bg-green-600/30">
                                    Lanjutkan ke Signing Process
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.documents.reject', $pengajuan->id) }}">
                                @csrf
                                <button type="submit"
                                        class="w-full px-4 py-3 rounded-xl bg-red-600/20 text-red-300 hover:bg-red-600/30">
                                    Tolak Dokumen
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="rounded-xl bg-white/5 p-4 text-sm text-slate-300">
                            Tidak ada aksi approval admin untuk status ini.
                        </div>
                    @endif

                    <div class="rounded-xl bg-black/20 p-4 text-sm space-y-2">
                        <p><span class="text-purple-300">Dibuat:</span> {{ $pengajuan->created_at?->format('d M Y H:i') }}</p>
                        <p><span class="text-purple-300">Diubah:</span> {{ $pengajuan->updated_at?->format('d M Y H:i') }}</p>
                        <p><span class="text-purple-300">Approved At:</span> {{ $pengajuan->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                        <p><span class="text-purple-300">Rejected At:</span> {{ $pengajuan->rejected_at?->format('d M Y H:i') ?? '-' }}</p>
                    </div>
                </aside>
            </div>

            <section class="glass rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-purple-300 mb-4">Riwayat Review</h2>

                @if($pengajuan->reviewLogs->count())
                    <div class="space-y-4">
                        @foreach($pengajuan->reviewLogs->sortByDesc('created_at') as $log)
                            <div class="rounded-xl bg-black/20 p-4 flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-medium">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                        oleh {{ $log->reviewer->name ?? 'Reviewer' }}
                                    </p>
                                    <p class="text-sm text-slate-400 mt-1">Level reviewer: {{ $log->reviewer_level }}</p>
                                    <p class="text-sm text-slate-300 mt-2">{{ $log->note ?: 'Tidak ada catatan.' }}</p>
                                </div>
                                <div class="text-xs text-slate-400 whitespace-nowrap">
                                    {{ $log->created_at?->format('d M Y H:i') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-400">Belum ada riwayat review.</p>
                @endif
            </section>
        </main>
    </div>

</body>
</html>
