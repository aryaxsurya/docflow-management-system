<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signing Process | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #0a1124; color: #e6eeff; }
        .glass { background: rgba(255,255,255,0.06); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- ================= SIDEBAR ================= -->
    @include('admin.sidebar')

    <!-- ================= MAIN CONTENT ================= -->
    <div class="flex-1 flex flex-col">
        @include('admin.topbar')

        <!-- ============ CONTENT ============ -->
        <main class="p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-purple-300">✍️ Signing Process</h1>
                <p class="text-purple-200 text-sm mt-2">Dokumen yang sedang dalam proses penandatanganan</p>
            </div>

            <div class="glass p-6 rounded-2xl overflow-x-auto">
                @if($pengajuan->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="text-purple-400 border-b border-white/10">
                            <tr>
                                <th class="py-2 text-left">Title</th>
                                <th class="py-2 text-left">User</th>
                                <th class="py-2 text-left">Type</th>
                                <th class="py-2 text-left">Submitted</th>
                                <th class="py-2 text-left">Progress</th>
                                <th class="py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($pengajuan as $item)
                                <tr>
                                    <td class="py-3 font-medium">{{ $item->judul }}</td>
                                    <td class="py-3">{{ $item->user->name }}</td>
                                    <td class="py-3">{{ $item->jenis ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="py-3">
                                        <div class="w-full bg-gray-700 rounded-full h-2">
                                            <div class="bg-yellow-400 h-2 rounded-full" style="width: 60%"></div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <a href="{{ route('admin.documents.show', $item->id) }}" class="text-blue-400 hover:underline text-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <p>✅ No documents in signing process</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pengajuan->links() }}
            </div>
        </main>
    </div>

</body>
</html>
