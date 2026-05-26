<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log | Admin Panel</title>
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

        <main class="p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-purple-300">Audit Log</h1>
                <p class="text-purple-200 text-sm mt-2">Semua history activity dan perubahan dokumen.</p>
            </div>

            <div class="glass p-6 rounded-2xl">
                @if($logs->count() > 0)
                    <div class="space-y-4">
                        @foreach($logs as $log)
                            <div class="flex gap-4 pb-4 border-b border-white/10">
                                <div class="flex-1">
                                    <div class="flex justify-between gap-4">
                                        <p class="font-medium">
                                            <strong>{{ $log->reviewer?->name ?? $log->pengajuan->user->name ?? 'System' }}</strong>
                                            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                        </p>
                                        <span class="text-xs text-gray-400">{{ $log->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-300 mt-1">
                                        Dokumen: <strong>{{ $log->pengajuan->judul ?? 'Unknown' }}</strong>
                                    </p>
                                    @if($log->note)
                                        <p class="text-xs text-gray-400 mt-1 italic">Catatan: {{ $log->note }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">
                                        Level: {{ $log->reviewer_level ?? 'N/A' }}
                                        @if($log->started_at && $log->finished_at)
                                            | Durasi: {{ $log->started_at->diffInHours($log->finished_at) }} jam
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <p>No audit logs yet.</p>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                {{ $logs->links() }}
            </div>
        </main>
    </div>

</body>
</html>
