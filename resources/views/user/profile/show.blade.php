<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #0a1124; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); }
    </style>
</head>

<body class="min-h-screen text-white flex">

    <!-- SIDEBAR -->
    <aside class="w-64 glass min-h-screen p-6">
        <h2 class="text-2xl font-bold text-blue-300 mb-10">👤 Profil</h2>

        <nav class="space-y-4">
            <a href="/dashboard/user" class="block hover:text-blue-400">🏠 Dashboard</a>
            <a href="/user/pengajuan/create" class="block hover:text-blue-400">📄 Pengajuan Dokumen</a>
            <a href="/user/pengajuan" class="block hover:text-blue-400">📁 Riwayat Pengajuan</a>
            <a href="{{ route('user.profile.show') }}" class="block text-blue-400 font-semibold">👤 Profil Saya</a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-10">

        <div class="glass p-10 rounded-2xl shadow-xl border border-white/10">

            <h1 class="text-3xl font-bold text-blue-300 mb-8">👤 Profil Saya</h1>

            <div class="flex items-start gap-8">

                <!-- Foto -->
                <img 
                    src="{{ $user->photo_url ? asset($user->photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                    class="w-32 h-32 rounded-full border border-white/20 shadow-xl object-cover">

                <div class="space-y-4">

                    <div>
                        <p class="text-white/50 text-sm">Nama</p>
                        <p class="text-xl font-semibold">{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="text-white/50 text-sm">Email</p>
                        <p class="text-lg">{{ $user->email }}</p>
                    </div>

                    @if($user->about)
                    <div>
                        <p class="text-white/50 text-sm">Tentang Saya</p>
                        <p class="text-white/90">{{ $user->about }}</p>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Tombol -->
            <div class="mt-10 flex gap-4">
                <a href="{{ route('user.profile') }}"
                   class="px-6 py-3 bg-blue-600 rounded-xl hover:bg-blue-700 transition text-white font-semibold">
                    ✏️ Edit Profil
                </a>

                <a href="/dashboard/user"
                   class="px-6 py-3 bg-white/10 border border-white/20 rounded-xl hover:bg-white/20 transition text-white">
                    ← Kembali
                </a>
            </div>

        </div>

    </main>
</body>
</html>
