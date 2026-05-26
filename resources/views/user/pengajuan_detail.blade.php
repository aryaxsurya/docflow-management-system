<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #0a1124; color: #e6eeff; }
        .glass {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
        }
    </style>
</head>

<body class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 glass min-h-screen p-6">
        <h2 class="text-2xl font-bold text-blue-300 mb-10 flex items-center gap-2">
            👤 User Panel
        </h2>

        <nav class="space-y-4">
            <a href="/dashboard/user" class="block hover:text-blue-400">🏠 Dashboard</a>
            <a href="/user/pengajuan/create" class="block hover:text-blue-400">📄 Pengajuan Dokumen</a>
            <a href="/user/pengajuan" class="block text-blue-400 font-semibold">📁 Riwayat Pengajuan</a>
            <a href="/user/profile" class="block hover:text-blue-400">⚙️ Pengaturan Akun</a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <div class="glass p-6 rounded-2xl mb-8">
            <h1 class="text-3xl font-bold text-blue-300">📄 Detail Pengajuan Dokumen</h1>
            <p class="text-blue-100 opacity-80">Informasi lengkap tentang dokumen yang Anda ajukan</p>
        </div>

        <!-- DETAIL CARD -->
        <div class="glass p-8 rounded-2xl space-y-6" data-aos="fade-up">

            <!-- ✏️ TOMBOL EDIT DRAFT (hanya untuk draft) -->
            @if ($pengajuan->status === 'draft')
                <div class="flex justify-end">
                    <a href="{{ route('pengajuan.edit', $pengajuan->id) }}"
                       class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-lg transition">
                        ✏️ Edit Draft
                    </a>
                </div>
            @endif

            <!-- 🔵 TIMELINE STATUS -->
            @php
                $steps = ['draft', 'review1', 'review2', 'review3', 'approved'];
                $currentIndex = array_search(strtolower($pengajuan->status), $steps);

                $labels = [
                    'draft'    => 'Draft',
                    'review1'  => 'Review 1',
                    'review2'  => 'Review 2',
                    'review3'  => 'Review 3',
                    'approved' => 'Approved',
                ];
            @endphp

            <div class="mt-4 mb-10">
                <div class="w-full max-w-3xl">
                    <!-- BARIS BULAT + GARIS -->
                    <div class="flex items-center">
                        @foreach ($steps as $index => $step)
                            @php $active = $index <= $currentIndex; @endphp

                            <div class="flex items-center">
                                <!-- BULAT -->
                                <div class="w-9 h-9 flex items-center justify-center rounded-full border-2 text-sm font-semibold
                                    {{ $active ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-500 text-gray-400' }}">
                                    {{ $index + 1 }}
                                </div>

                                <!-- GARIS -->
                                @if (!$loop->last)
                                    <div class="w-32 h-1 mx-1
                                        {{ $index < $currentIndex ? 'bg-blue-600' : 'bg-gray-600' }}">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <!-- LABEL STATUS -->
                    <div class="flex mt-2">
                        @foreach ($steps as $index => $step)
                            <div class="flex items-start"
                                style="width: 9rem">
                                <span class="text-xs text-blue-200 opacity-80">
                                    {{ $labels[$step] ?? ucfirst($step) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- JUDUL & DESKRIPSI -->
            <div>
                <h2 class="text-2xl font-semibold text-blue-200 mb-2">{{ $pengajuan->judul }}</h2>
                <p class="text-blue-100 opacity-80">{{ $pengajuan->deskripsi }}</p>
            </div>

            <!-- GRID INFORMASI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                <div>
                    <p class="text-blue-300 font-semibold">Jenis Dokumen:</p>
                    <p class="opacity-80">{{ $pengajuan->jenis }}</p>
                </div>

                <div>
                    <p class="text-blue-300 font-semibold">Unit Kerja:</p>
                    <p class="opacity-80">{{ $pengajuan->unit_kerja }}</p>
                </div>

                <div>
                    <p class="text-blue-300 font-semibold">Tanggal Berlaku:</p>
                    <p class="opacity-80">
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_berlaku)->format('d F Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-blue-300 font-semibold">Status:</p>
                    <span class="px-3 py-1 rounded-lg text-sm bg-blue-700">
                        {{ ucfirst($pengajuan->status) }}
                    </span>
                </div>

            </div>

            <!-- FILE DOWNLOAD -->
            <div class="mt-8">
                <p class="text-blue-300 font-semibold mb-2">Lampiran Dokumen:</p>

                @if ($pengajuan->lampiran)
                    <a href="{{ asset('storage/' . $pengajuan->lampiran) }}"
                        download
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg inline-block transition">
                        ⬇️ Download Lampiran
                    </a>
                @else
                    <p class="text-red-300">❗ Tidak ada file yang diunggah.</p>
                @endif
            </div>

            <!-- REVIEW LOGS (untuk user melihat catatan reviewer) -->
            <div class="mt-6">
                <h3 class="text-blue-300 font-semibold mb-3">📝 Riwayat Review</h3>

                @php
                    $logs = $pengajuan->reviewLogs()->with('reviewer')->latest()->get();
                @endphp

                @if($logs->isEmpty())
                    <p class="text-slate-500 italic">Belum ada catatan review.</p>
                @else
                    <div class="space-y-4">
                        @foreach($logs as $log)
                            @php
                                $action = $log->action;
                                if ($action === 'approve') {
                                    $accent = 'green';
                                    $label = 'Disetujui';
                                } elseif ($action === 'request_changes') {
                                    $accent = 'yellow';
                                    $label = 'Diminta Perubahan';
                                } elseif ($action === 'reject') {
                                    $accent = 'red';
                                    $label = 'Ditolak';
                                } else {
                                    $accent = 'slate';
                                    $label = ucfirst($action ?: 'Log');
                                }
                            @endphp

                            <div class="glass p-4 rounded-lg border-l-4 border-{{ $accent }}-500/50 flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="text-sm font-semibold text-{{ $accent }}-300">{{ $label }}</div>
                                        <div class="text-xs text-slate-400">oleh {{ $log->reviewer?->name ?? 'Reviewer' }}</div>
                                    </div>

                                    @if(!empty($log->note))
                                        <div class="mt-2 text-slate-100 whitespace-pre-line">{{ $log->note }}</div>
                                    @endif
                                </div>

                                <div class="text-right text-xs text-slate-400">
                                    <div>{{ ($log->finished_at ?? $log->created_at)->diffForHumans() }}</div>
                                    <div class="text-slate-500 mt-1">{{ ($log->finished_at ?? $log->created_at)->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- BUTTON BACK -->
            <div class="flex justify-between mt-10">
                <a href="/user/pengajuan"
                    class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl shadow">
                    ← Kembali
                </a>
            </div>

        </div>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 900 });
    </script>

</body>
</html>
