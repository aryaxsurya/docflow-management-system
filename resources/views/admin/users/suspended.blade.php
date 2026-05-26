<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspended Users | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #0a1124; color: #e6eeff; }
        .glass { background: rgba(255,255,255,0.06); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- ================= SIDEBAR =================  -->
   @include('admin.sidebar')

    <!-- ================= MAIN CONTENT ================= -->
    <div class="flex-1 flex flex-col">
        @include('admin.topbar')

        <!-- ============ CONTENT ============ -->
        <main class="p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-purple-300">🚫 Suspended Users</h1>
                <p class="text-purple-200 text-sm mt-2">Users yang telah di-suspend dari sistem</p>
            </div>

            <div class="glass p-6 rounded-2xl overflow-x-auto">
                @if($users->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="text-purple-400 border-b border-white/10">
                            <tr>
                                <th class="py-2 text-left">Name</th>
                                <th class="py-2 text-left">Email</th>
                                <th class="py-2 text-left">Role</th>
                                <th class="py-2 text-left">Suspended</th>
                                <th class="py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-3">{{ $user->name }}</td>
                                    <td class="py-3">{{ $user->email }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 bg-gray-600 rounded text-xs">{{ ucfirst($user->role) }}</span>
                                    </td>
                                    <td class="py-3">{{ $user->updated_at->format('d M Y') }}</td>
                                    <td class="py-3">
                                        <button class="text-green-400 hover:underline text-sm">Unsuspend</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <p>✅ No suspended users</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </main>
    </div>

</body>
</html>
