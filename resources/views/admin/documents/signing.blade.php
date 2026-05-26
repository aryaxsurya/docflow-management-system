<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #0a1124; color: #e6eeff; }
        .glass { background: rgba(255,255,255,0.06); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body class="min-h-screen flex">

    @include('admin.sidebar')

    <div class="flex-1 flex flex-col">
        @include('admin.topbar')

        <main class="p-8 space-y-6">
            <div>
                <h1 class="text-3xl font-bold text-purple-300">{{ $title }}</h1>
                <p class="text-purple-200 text-sm mt-2">{{ $description }}</p>
            </div>

            @if(session('success'))
                <div class="glass p-4 rounded-xl text-green-300">{{ session('success') }}</div>
            @endif

            <div class="glass p-6 rounded-2xl overflow-x-auto">
                @if($documents->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="text-purple-400 border-b border-white/10">
                            <tr>
                                <th class="py-2 text-left">Judul</th>
                                <th class="py-2 text-left">Pengaju</th>
                                <th class="py-2 text-left">Jenis</th>
                                <th class="py-2 text-left">Status</th>
                                <th class="py-2 text-left">Deadline</th>
                                <th class="py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($documents as $item)
                                <tr>
                                    <td class="py-3 font-medium">{{ $item->judul }}</td>
                                    <td class="py-3">{{ $item->user->name ?? '-' }}</td>
                                    <td class="py-3">{{ $item->jenis ?? '-' }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 bg-white/10 rounded text-xs">{{ $item->status_label }}</span>
                                    </td>
                                    <td class="py-3">{{ $item->tanggal_berlaku?->format('d M Y') ?? '-' }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('admin.documents.show', $item->id) }}" class="text-blue-400 hover:underline text-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <p>Tidak ada dokumen pada status {{ strtolower($statusBadge) }}.</p>
                    </div>
                @endif
            </div>

            <div>
                {{ $documents->links() }}
            </div>
        </main>
    </div>

</body>
</html>
