<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer Login | Document Workflow System</title>

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
        <div class="absolute top-20 left-20 text-indigo-400 text-[180px] opacity-10">◆</div>
        <div class="absolute bottom-10 right-20 text-purple-400 text-[240px] opacity-10">◆</div>
    </div>

    <div class="glass p-10 rounded-3xl shadow-2xl max-w-md w-full" data-aos="fade-up">

        <div class="text-center mb-8">
            <div class="text-indigo-400 text-6xl mb-2">🕵️‍♂️</div>
            <h2 class="text-3xl font-bold text-indigo-300">Reviewer Login</h2>
            <p class="text-indigo-100 opacity-80 mt-2">Masuk sebagai verifikator / reviewer dokumen.</p>
        </div>

        <!-- Flash Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-500/20 border border-red-400/50 rounded-xl text-red-200 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-500/20 border border-red-400/50 rounded-xl text-red-200 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-500/20 border border-green-400/50 rounded-xl text-green-200 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.reviewer.store') }}" method="POST">
            @csrf

            <label class="font-semibold">Email</label>
            <input type="email" name="email" required value="{{ old('email') }}"
                class="w-full mt-2 mb-5 px-4 py-3 bg-white/10 rounded-xl border border-white/20 text-indigo-100 focus:ring-2 focus:ring-indigo-400 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label class="font-semibold mt-4">Password</label>
            <input type="password" name="password" required
                class="w-full mt-2 mb-6 px-4 py-3 bg-white/10 rounded-xl border border-white/20 text-indigo-100 focus:ring-2 focus:ring-indigo-400 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full bg-indigo-600 py-3 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-indigo-300 hover:text-indigo-400">
                ← Kembali ke Home
            </a>
        </div>

    </div>

    <div class="absolute bottom-44 left-4 text-blue-300 text-sm bg-white/5 px-4 py-2 rounded-lg border border-white/10">
        <p class="font-semibold">🔑 Demo Login</p>
        <p>Username: <span class="text-white">rev1@view.er</span></p>
        <p>Password: <span class="text-white">password</span></p>
    </div>
    <div class="absolute bottom-24 left-4 text-blue-300 text-sm bg-white/5 px-4 py-2 rounded-lg border border-white/10">
        <p class="font-semibold">🔑 Demo Login</p>
        <p>Username: <span class="text-white">rev2@view.er</span></p>
        <p>Password: <span class="text-white">password</span></p>
    </div>
    <div class="absolute bottom-4 left-4 text-blue-300 text-sm bg-white/5 px-4 py-2 rounded-lg border border-white/10">
        <p class="font-semibold">🔑 Demo Login</p>
        <p>Username: <span class="text-white">rev3@view.er</span></p>
        <p>Password: <span class="text-white">password</span></p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init({ once: true, duration: 900 }); </script>
</body>
</html>
