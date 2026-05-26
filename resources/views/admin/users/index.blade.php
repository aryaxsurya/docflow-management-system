<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All Users</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0a1124;
            color: #e6eeff;
        }

        .glass {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.08);
        }
    </style>
</head>

<body class="min-h-screen flex">

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <header class="glass px-8 py-4 flex justify-between items-center">
            <input 
                type="text" 
                placeholder="🔍 Search user..."
                class="w-1/3 px-4 py-2 rounded-lg bg-white/10 border border-white/20"
            >
        </header>

        <main class="p-8 space-y-6">

            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-purple-300">
                    👤 All Users
                </h1>

                <a 
                    href="{{ route('admin.dashboard') }}"
                    class="text-blue-300 hover:text-blue-400"
                >
                    ⬅ Back to Dashboard
                </a>
            </div>

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-400 text-green-300 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="glass rounded-2xl overflow-hidden">

                <table class="w-full text-sm">

                    <thead class="bg-white/5 text-purple-300">
                        <tr>
                            <th class="p-4 text-left">Name</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">Role</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Registered</th>
                            <th class="p-4 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">

                        @foreach($users as $user)
                            <tr>

                                <td class="p-4">
                                    {{ $user->name }}
                                </td>

                                <td class="p-4">
                                    {{ $user->email }}
                                </td>

                                <td class="p-4">
                                    <span class="px-3 py-1 rounded text-xs bg-indigo-500/20 text-indigo-300">
                                        {{ $user->role }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    @if($user->status == 'approved')
                                        <span class="text-green-400">Active</span>
                                    @elseif($user->status == 'pending')
                                        <span class="text-yellow-400">Pending</span>
                                    @else
                                        <span class="text-red-400">Suspended</span>
                                    @endif
                                </td>

                                <td class="p-4">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>

                                <td class="p-4 flex gap-3">

                                    <a 
                                        href="{{ route('admin.users.edit', $user->id) }}"
                                        class="text-blue-400 hover:underline text-sm"
                                    >
                                        Edit
                                    </a>

                                    <form 
                                        method="POST"
                                        action="{{ route('admin.users.suspend', $user->id) }}"
                                        onsubmit="return confirm('Toggle suspend user?')"
                                    >
                                        @csrf
                                        <button class="text-yellow-400 hover:underline text-sm">
                                            {{ $user->status == 'suspended' ? 'Activate' : 'Suspend' }}
                                        </button>
                                    </form>

                                    <form 
                                        method="POST"
                                        action="{{ route('admin.users.delete', $user->id) }}"
                                        onsubmit="return confirm('Yakin hapus user ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-400 hover:underline text-sm">
                                            Delete
                                        </button>
                                    </form>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </main>

    </div>

</body>
</html>