<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: "Inter", sans-serif;
            background: #0a1124;
            color: #e6eeff;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .status-draft {
            background: rgba(107, 114, 128, 0.2);
            color: #d1d5db;
            border: 1px solid rgba(107, 114, 128, 0.3);
        }

        .status-review1 {
            background: rgba(227, 243, 3, 0.15);
            color: #0beedb;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .status-review2 {
            background: rgba(227, 243, 3, 0.15);
            color: #0a80ee;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .status-review3 {
            background: rgba(227, 243, 3, 0.15);
            color: #0a5aee;
            border: 1px solid rgba(236, 72, 153, 0.28);
        }
        .status-approved {
            background: rgba(34, 197, 94, 0.2);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <div class="glass p-6 rounded-2xl mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-blue-300 mb-2">📁 Riwayat Pengajuan</h1>
                    <p class="text-blue-100 opacity-80">Kelola dan pantau semua pengajuan dokumen Anda</p>
                </div>
                <a href="/user/pengajuan/create"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold shadow-lg transition transform hover:scale-105">
                    ➕ Pengajuan Baru
                </a>
            </div>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-400/50 rounded-xl text-green-200">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- TABLE RIWAYAT -->
        @if ($pengajuan->count() > 0)
            <div class="glass p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                <table class="w-full text-sm">
                    <thead class="text-blue-300 border-b border-blue-700/50">
                        <tr>
                            <th class="text-left py-3 px-4">No</th>
                            <th class="text-left py-3 px-4">Judul</th>
                            <th class="text-left py-3 px-4">Jenis</th>
                            <th class="text-left py-3 px-4">Unit Kerja</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Tanggal Berlaku</th>
                            <th class="text-left py-3 px-4">Dibuat</th>
                            <th class="text-center py-3 px-4">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $item)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 font-semibold">{{ $item->judul }}</td>
                                <td class="py-3 px-4">{{ $item->jenis }}</td>
                                <td class="py-3 px-4">{{ $item->unit_kerja }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $status = strtolower($item->status);
                                        $statusClass = match ($status) {
                                            'draft' => 'status-draft',
                                            'review1' => 'status-review1',
                                            'review2' => 'status-review2',
                                            'review3' => 'status-review3',
                                            'approved' => 'status-approved',
                                            'rejected' => 'status-rejected',
                                            default => 'status-draft'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($item->tanggal_berlaku)->format('d-m-Y') }}</td>
                                <td class="py-3 px-4">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                <td class="py-3 px-4 text-center">
                                    <a href="/user/pengajuan/{{ $item->id }}" 
                                        class="text-blue-400 hover:text-blue-300 transition text-lg" 
                                        title="Lihat Detail">
                                        👁️
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-blue-100 opacity-60">
                                    📭 Belum ada pengajuan. <a href="/user/pengajuan/create" class="text-blue-400 hover:text-blue-300 underline">Buat pengajuan baru →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="glass p-12 rounded-2xl text-center" data-aos="fade-up">
                <div class="text-6xl mb-4">📭</div>
                <h2 class="text-2xl font-semibold text-blue-300 mb-2">Belum Ada Pengajuan</h2>
                <p class="text-blue-100 opacity-80 mb-6">Mulai buat pengajuan dokumen pertama Anda sekarang.</p>
                <a href="/user/pengajuan/create"
                    class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold shadow-lg transition transform hover:scale-105">
                    ➕ Buat Pengajuan Baru
                </a>
            </div>
        @endif

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 900 });
    </script>
</body>

</html>