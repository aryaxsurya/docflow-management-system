<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Workflow System</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- 3D Parallax -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* GLASS EFFECT */
        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* AUTO SYSTEM DARK MODE + BLUE TONE */
        @media (prefers-color-scheme: dark) {
            body {
                background: #0a1124;
                color: #d4e1ff;
            }
        }

        @media (prefers-color-scheme: light) {
            body {
                background: #e8efff;
                color: #1a1f2e;
            }
        }

    </style>
</head>

<body class="min-h-screen">

    <!-- NAVBAR -->
    <nav class="glass fixed w-full top-0 left-0 z-50 py-4">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            
            <div class="text-xl font-bold text-blue-300 drop-shadow">
                📄 Document Workflow
            </div>

            <div class="flex gap-4">
                <a href="/login/user"
                   class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    User Login
                </a>
                <a href="/login/reviewer"
                   class="px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    Reviewer Login
                </a>
                <a href="/login/admin"
                   class="px-3 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition">
                    Admin Login
                </a>
            </div>

        </div>
    </nav>

    <!-- COPYRIGHT BAR (DI BAWAH NAVBAR) -->
    <div class="w-full text-center text-xs text-blue-300 py-2
            bg-[#0e1a33] border-b border-blue-500/10 mt-20">
        © {{ date('Y') }} Document Workflow System —
        <span class="text-blue-400">Created by Arya Surya</span>
    </div>

    <!-- PARALLAX HERO -->
    <section id="hero" class="relative text-white overflow-hidden pt-32 pb-24">

        <!-- Parallax Container -->
        <div id="parallax-scene" class="absolute inset-0 pointer-events-none">
            <div data-depth="0.1" class="absolute top-20 left-10 text-blue-400 opacity-20 text-8xl">●</div>
            <div data-depth="0.3" class="absolute bottom-10 right-20 text-indigo-400 opacity-20 text-9xl">●</div>
            <div data-depth="0.2" class="absolute top-40 right-40 text-blue-500 opacity-20 text-7xl">●</div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6" data-aos="fade-up">

            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 text-blue-300 drop-shadow-lg">
                Document Workflow System
            </h1>

            <p class="text-xl md:text-2xl max-w-2xl text-blue-100 opacity-90">
                Sistem profesional untuk pengajuan, review, dan persetujuan dokumen berbasis otomatis & efisien.
                
            </p>


        </div>

        <!-- Blue Wave -->
        <svg class="absolute bottom-0 w-full" viewBox="0 0 1440 150">
            <path fill="#0e1a33" d="M0,96L1440,0L1440,150L0,150Z"></path>
        </svg>

    </section>

    <!-- FITUR -->
    <section class="py-20 bg-[#0e1a33] text-blue-100">
        <div class="max-w-7xl mx-auto px-6">
            
            <h2 class="text-4xl font-bold text-center mb-14 text-blue-300" data-aos="fade-down">
                Fitur Utama Sistem
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <!-- 1 -->
                <div class="glass p-8 rounded-2xl shadow-xl hover:-translate-y-1 transition" data-aos="fade-right">
                    <div class="text-blue-400 text-5xl mb-4">📝</div>
                    <h3 class="text-2xl font-bold mb-3 text-blue-200">Pengajuan Dokumen</h3>
                    <p class="opacity-80">
                        Ajukan dokumen lengkap dengan detail, kategori, deskripsi, dan lampiran.
                    </p>
                </div>

                <!-- 2 -->
                <div class="glass p-8 rounded-2xl shadow-xl hover:-translate-y-1 transition" data-aos="fade-up">
                    <div class="text-indigo-400 text-5xl mb-4">⚙️</div>
                    <h3 class="text-2xl font-bold mb-3 text-blue-200">Auto Save Draft</h3>
                    <p class="opacity-80">
                        Sistem menyimpan otomatis setiap perubahan tanpa klik Save.
                    </p>
                </div>

                <!-- 3 -->
                <div class="glass p-8 rounded-2xl shadow-xl hover:-translate-y-1 transition" data-aos="fade-left">
                    <div class="text-cyan-400 text-5xl mb-4">🔔</div>
                    <h3 class="text-2xl font-bold mb-3 text-blue-200">Notifikasi Reviewer</h3>
                    <p class="opacity-80">
                        Reviewer langsung menerima notifikasi saat dokumen dikirim.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-[#081226] text-center text-blue-100">
        <h2 class="text-4xl font-bold mb-4 text-blue-300" data-aos="zoom-in">Siap Kelola Dokumen Anda?</h2>
        <p class="opacity-80 mb-6 text-blue-200">Sistem workflow cepat, modern, dan efisien.</p>

        <a href="/register"
           class="px-10 py-4 bg-blue-500 text-white font-semibold rounded-xl shadow-lg hover:bg-blue-600 transition"
           data-aos="zoom-in-up">
           📋 Daftar User
        </a>
    </section>

    <!-- FOOTER -->
    <footer class="py-6 text-center text-blue-300 text-sm bg-[#0a1124]">
        © {{ date('Y') }} Document Workflow System —
        <span class="text-blue-400">Created by Arya Surya</span>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 900,
        });

        // Parallax init
        var scene = document.getElementById('parallax-scene');
        var parallaxInstance = new Parallax(scene);
    </script>

</body>
</html>
