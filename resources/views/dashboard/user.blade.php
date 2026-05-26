<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

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
            <a href="/user/pengajuan" class="block hover:text-blue-400">📁 Riwayat Pengajuan</a>
            <a href="/user/profile" class="block hover:text-blue-400">⚙️ Pengaturan Akun</a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER PREMIUM -->
        <div class="relative mb-10 overflow-hidden rounded-3xl">
            <!-- Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 opacity-90"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-blue-900/50"></div>

            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-blue-400 rounded-full opacity-10 blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-400 rounded-full opacity-10 blur-3xl -ml-32 -mb-32"></div>

            <!-- Content -->
            <div class="relative p-10 flex justify-between items-center z-10">
                <div class="flex items-center gap-6">
                    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-5 border border-white/30">
                        <div class="text-5xl">👤</div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">Selamat Datang!</h1>
                        <p class="text-blue-100 text-lg">{{ optional(auth()->user())->name ?? 'Guest' }}</p>
                        <p class="text-blue-200 text-sm mt-1">📅 {{ date('l, d F Y') }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold shadow-lg transition transform hover:scale-105">
                            🚪 Logout
                        </button>
                    </form>

                    <a href="/user/profile/show" class="px-6 py-3 bg-white/20 hover:bg-white/30 text-white rounded-xl font-semibold border border-white/30 transition">
                        ⚙️ Profil
                    </a>
                </div>
            </div>

            <!-- (OLD Stats bar removed) -->
        </div>

        <!-- ========================================================= -->
        <!-- 1) NEW STATS BAR -->
        <!-- ========================================================= -->
        <div class="grid grid-cols-3 gap-4 mb-6">

            <div class="glass p-4 rounded-xl">
                <p class="text-sm text-white/60">Pengajuan Aktif</p>
                <p class="text-2xl font-bold text-yellow-400">{{ $stats['aktif'] }}</p>
            </div>

            <div class="glass p-4 rounded-xl">
                <p class="text-sm text-white/60">Disetujui</p>
                <p class="text-2xl font-bold text-green-400">{{ $stats['approved'] }}</p>
            </div>

            <div class="glass p-4 rounded-xl">
                <p class="text-sm text-white/60">Ditolak</p>
                <p class="text-2xl font-bold text-red-400">{{ $stats['rejected'] }}</p>
            </div>

        </div>

        <!-- ========================================================= -->
        <!-- 2) NEW TABEL PENGAJUAN TERBARU -->
        <!-- ========================================================= -->
        <div class="glass p-6 rounded-2xl mt-8">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-bold text-blue-300">📌 Pengajuan Terbaru</h2>
                <a href="{{ route('pengajuan.index') }}" class="text-blue-400 hover:text-blue-300">
                    Lihat Semua →
                </a>
            </div>

            <table class="w-full text-left text-white/80">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="py-2">Judul</th>
                        <th class="py-2">Jenis</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($latestPengajuan as $p)
                        <tr class="border-b border-white/5">
                           <td class="py-3">{{ $p->judul }}</td>
                           <td>{{ $p->jenis }}</td>

                           <td>
                               @php
                                   $color = match($p->status) {
                                       'draft'     => 'bg-gray-600',
                                       'review1'   => 'bg-yellow-600',
                                       'review3'   => 'bg-yellow-800',
                                       'review2'   => 'bg-orange-400',
                                       'approved'  => 'bg-green-600',
                                       'rejected'  => 'bg-red-900',
                                       default     => 'bg-gray-600'
                                  };
                              @endphp

                              <span class="px-3 py-1 rounded-lg text-white text-sm {{ $color }}">
                                 {{ $p->status }}
                               </span>
                          </td>

                          <td>{{ $p->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                           <td colspan="4" class="py-4 text-center text-white/60">
                               Belum ada pengajuan.
                           </td>
                       </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ACTION BUTTON -->
        <div class="flex justify-end mt-6">
            <a href="/user/pengajuan/create"
            class="inline-flex items-center gap-2 px-6 py-3
                bg-blue-600 hover:bg-blue-700
                text-white font-semibold rounded-xl
                shadow-lg transition transform hover:scale-105">
            ➕ Pengajuan
            </a>
</div>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true, duration: 900 });</script>
</body>

</html>
