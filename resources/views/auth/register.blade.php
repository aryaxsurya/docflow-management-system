<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Document Workflow System</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
        }
        @media (prefers-color-scheme: dark) {
            body { background: #081226; color: #d4e1ff; }
        }
        @media (prefers-color-scheme: light) {
            body { background: #e8efff; color: #1a1f2e; }
        }
    </style>
</head>

<body class="min-h-screen">

    <nav class="glass w-full fixed top-0 left-0 z-50 py-4">
        <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
            <div class="text-xl font-bold text-blue-300">📄 Document Workflow</div>
            <a href="/" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">⬅️ Home</a>
        </div>
    </nav>

    <section class="pt-32 pb-20 flex justify-center">

        <div class="glass p-10 rounded-2xl w-full max-w-xl shadow-xl">

            <h2 class="text-3xl font-bold text-center mb-6 text-blue-300">Registrasi Akun</h2>

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-600/20 border border-green-500 text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="font-semibold">Nama Lengkap</label>
                    <input type="text" name="name" required
                        class="w-full mt-2 px-4 py-3 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div class="mb-5">
                    <label class="font-semibold">Email</label>
                    <input type="email" name="email" required
                        class="w-full mt-2 px-4 py-3 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div class="mb-5">
                    <label class="font-semibold">Password</label>
                    <input type="password" name="password" required
                        class="w-full mt-2 px-4 py-3 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div class="mb-5">
                    <label class="font-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full mt-2 px-4 py-3 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div class="mb-5">
                    <label class="font-semibold">Daftar sebagai:</label>
                    <select name="role" required
                        class="w-full mt-2 px-4 py-3 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-indigo-400 outline-none">
                        <option value="user">👤 User</option>
                        <option value="reviewer">🕵️ Reviewer</option>
                    </select>
                </div>

                <button class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                    🚀 Kirim Pendaftaran
                </button>
            </form>

        </div>

    </section>

</body>
</html>
