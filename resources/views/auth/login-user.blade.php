<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #0a1124; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center relative">

    <!-- LOGIN CARD -->
    <div class="glass p-10 rounded-2xl w-full max-w-md shadow-xl border border-blue-600/30">
        <h2 class="text-3xl font-bold text-blue-300 mb-6 text-center">👤 User Login</h2>

        @if(session('error'))
            <div class="bg-red-700 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.user.store') }}">
            @csrf

            <div>
                <label>Email</label>
                <input name="email" type="email" value="{{ old('email') }}" 
                       class="w-full p-3 rounded-lg bg-white/10 mt-1 text-white" required>
            </div>

            <div class="mt-4">
                <label>Password</label>
                <input name="password" type="password" 
                       class="w-full p-3 rounded-lg bg-white/10 mt-1 text-white" required>
            </div>

            <button class="w-full mt-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-white font-semibold">
                Login
            </button>
        </form>

        <a href="/register"
           class="block text-center mt-4 text-blue-400 hover:text-blue-300">
            📝 Belum punya akun? Daftar
        </a>

        <a href="/" class="block text-center mt-4 text-blue-400 hover:text-blue-300">⬅ Kembali</a>
    </div>


    <!-- 📌 DEMO CREDENTIAL FOOTER -->
    <div class="absolute bottom-44 right-4 w-56 text-blue-300 text-sm bg-white/5 px-4 py-2 rounded-lg border border-white/10">
        <p class="font-semibold">🔑 Demo Login</p>
        <p>Username: <span class="text-white">mac@ser.com</span></p>
        <p>Password: <span class="text-white">password</span></p>
    </div>
    <div class="absolute bottom-24 right-4 w-56 text-blue-300 text-sm bg-white/5 px-4 py-2 rounded-lg border border-white/10">
        <p class="font-semibold">🔑 Demo Login</p>
        <p>Username: <span class="text-white">user1@ser.com</span></p>
        <p>Password: <span class="text-white">password</span></p>
    </div>
    <div class="absolute bottom-4 right-4 w-56 text-blue-300 text-sm bg-white/5 px-4 py-2 rounded-lg border border-white/10">
        <p class="font-semibold">🔑 Demo Login</p>
        <p>Username: <span class="text-white">user2@ser.com</span></p>
        <p>Password: <span class="text-white">password</span></p>
    </div>


</body>
</html>
