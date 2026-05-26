<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: "Inter", sans-serif;
            background: #0a1124 !important;
            color: #e6eeff;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
        }
    </style>
</head>

<body>

<div class="flex text-white min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 glass min-h-screen p-6">
        <h2 class="text-2xl font-bold text-blue-300 mb-10 flex items-center gap-2">
            ⚙️ Pengaturan
        </h2>

        <nav class="space-y-4">
            <a href="/dashboard/user" class="block hover:text-blue-400">🏠 Dashboard</a>
            <a href="/user/pengajuan/create" class="block hover:text-blue-400">📄 Pengajuan Dokumen</a>
            <a href="/user/pengajuan" class="block hover:text-blue-400">📁 Riwayat Pengajuan</a>
            <a href="/user/profile" class="block text-blue-400 font-semibold">⚙️ Pengaturan Akun</a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER PREMIUM -->
        <div class="relative mb-12 rounded-3xl shadow-2xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-500 to-cyan-500 opacity-95"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-transparent to-blue-900/70"></div>
            <div class="absolute top-0 right-0 w-72 h-72 bg-blue-300 rounded-full blur-3xl opacity-20 -mt-24 -mr-24"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-300 rounded-full blur-3xl opacity-20 -mb-24 -ml-24"></div>

            <div class="relative p-10 flex items-center gap-6 z-10">
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-5 border border-white/30 shadow-xl">
                    <div class="text-5xl">⚙️</div>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-white tracking-wide">Pengaturan Akun</h1>
                    <p class="text-blue-100 text-lg mt-1">Kelola identitas dan data pribadi Anda</p>
                </div>
            </div>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="bg-green-600/80 backdrop-blur-md text-white px-4 py-3 rounded-lg mb-6 shadow-lg border border-green-400/20">
                ✔️ {{ session('success') }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
              class="glass p-10 rounded-3xl border border-white/10 shadow-xl space-y-8">
            @csrf

            <!-- PHOTO -->
            <div class="flex items-center gap-8">

                <div class="relative group">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 blur-lg opacity-40 group-hover:opacity-60 transition"></div>

                    <img 
                        src="{{ auth()->user()->photo_url ? asset(auth()->user()->photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                        class="relative w-28 h-28 rounded-full border-2 border-white/20 shadow-xl object-cover">
                </div>

                <div>
                    <label class="block text-sm text-white/60 mb-1">Ubah Foto Profil</label>
                    <input type="file" name="photo"
                           class="text-white bg-white/5 border border-white/20 rounded-lg px-3 py-2 cursor-pointer">
                    <p class="text-xs text-white/40 mt-1">Format: JPG, PNG — max 2MB</p>
                </div>
            </div>

            <!-- NAME -->
            <div>
                <label class="block text-white/80 mb-2 font-semibold">Nama Lengkap</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}"
                    class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white 
                        focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-white/80 mb-2 font-semibold">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}"
                    class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white 
                    focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- ABOUT -->
            <div>
                <label class="block text-white/80 mb-2 font-semibold">About Me</label>
                <textarea name="about" rows="4"
                    class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white 
                    focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Tulis sedikit tentang diri Anda...">{{ auth()->user()->about_me }}</textarea>
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-white/80 mb-2 font-semibold">Password Baru (Opsional)</label>
                <input type="password" name="password" 
                    class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white 
                    focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Biarkan kosong jika tidak ingin mengubah password">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-between items-center pt-6">
                <a href="/dashboard/user"
                    class="px-6 py-3 bg-white/10 border border-white/20 rounded-xl text-white 
                        hover:bg-white/20 transition shadow-lg flex items-center gap-2">
                    ← Kembali
                </a>

                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 
                        hover:from-blue-700 hover:to-cyan-700 rounded-xl text-white font-semibold 
                        shadow-lg transition transform hover:scale-105">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>

    </main>
</div>

</body>
</html>
