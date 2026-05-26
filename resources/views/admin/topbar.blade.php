<!-- ============ TOPBAR ============ -->
<header class="glass px-8 py-4 flex justify-between items-center">

    <div class="w-1/3">
        <input type="text"
               placeholder="Search document, user..."
               class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-purple-400 outline-none text-sm">
    </div>

    <div class="flex items-center gap-6">
        <div class="relative cursor-pointer">
            Notifications
            <span class="absolute -top-2 -right-2 bg-red-500 text-xs px-2 py-0.5 rounded-full">
                0
            </span>
        </div>

        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-sm font-bold">
                {{ strtoupper(Auth::user()->name[0] ?? 'A') }}
            </div>
            <div class="text-sm">
                <p class="font-semibold">{{ Auth::user()->name ?? 'Admin' }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-300 text-xs hover:text-red-400">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

</header>
