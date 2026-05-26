<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pending | Document Workflow System</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.15); }
        @media (prefers-color-scheme: dark) { body { background: #0a1124; color: #e6eeff; } }
        @media (prefers-color-scheme: light) { body { background: #e8efff; color: #1a1f2e; } }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-6 py-14">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 text-blue-500 text-[180px] opacity-10">⏳</div>
        <div class="absolute bottom-10 right-20 text-green-500 text-[240px] opacity-10">✓</div>
    </div>

    <div class="glass p-10 rounded-3xl shadow-2xl max-w-md w-full text-center" data-aos="fade-up">

        <div class="text-blue-400 text-6xl mb-4">⏳</div>
        <h2 class="text-3xl font-bold text-blue-300 mb-4">Verifikasi Pending</h2>

        <div class="mb-6">
            @if(session('message'))
                <p class="text-blue-200 text-lg leading-relaxed">
                    {{ session('message') }}
                </p>
            @else
                <p class="text-blue-200 text-lg leading-relaxed">
                    Pendaftaran berhasil! Akun Anda sedang dalam proses verifikasi oleh admin. Anda akan mendapat notifikasi setelah disetujui.
                </p>
            @endif
        </div>

        <div class="space-y-4">
            <a href="/"
               class="block w-full py-3 bg-gray-600 hover:bg-gray-700 rounded-xl text-white font-semibold transition-colors">
                Kembali ke Beranda
            </a>
        </div>

        <div class="mt-8 text-sm text-blue-300 opacity-80">
            <p>📧 Periksa email Anda untuk informasi lebih lanjut</p>
            <p>⏰ Proses verifikasi biasanya memakan waktu 1-2 hari kerja</p>
        </div>

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>
</html>