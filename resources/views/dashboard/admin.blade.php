<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background: #0a1124; color: #e6eeff; }
        .glass {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body class="min-h-screen flex">

    @include('admin.sidebar')

    <div class="flex-1 flex flex-col">
        @include('admin.topbar')

        <main class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl">
                    <p class="text-purple-300 text-sm">Pending Users</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $pendingUsers ?? 0 }}</h3>
                </div>

                <div class="glass p-6 rounded-2xl">
                    <p class="text-purple-300 text-sm">Waiting Approval</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $pendingDocs ?? 0 }}</h3>
                </div>

                <div class="glass p-6 rounded-2xl">
                    <p class="text-purple-300 text-sm">Signing Process</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $signingProcess ?? 0 }}</h3>
                </div>

                <div class="glass p-6 rounded-2xl">
                    <p class="text-purple-300 text-sm">Archived This Month</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $signedDocs ?? 0 }}</h3>
                </div>
            </div>

            <div class="glass p-6 rounded-2xl">
                <h2 class="text-lg font-semibold mb-4 text-purple-300">Action Required</h2>

                @if($recentPengajuan->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-purple-400 border-b border-white/10">
                                <tr>
                                    <th class="py-2 text-left">Document</th>
                                    <th class="py-2 text-left">User</th>
                                    <th class="py-2 text-left">Status</th>
                                    <th class="py-2 text-left">Deadline</th>
                                    <th class="py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($recentPengajuan as $pengajuan)
                                    <tr>
                                        <td class="py-3 font-medium">{{ $pengajuan->judul ?? 'N/A' }}</td>
                                        <td class="py-3 text-gray-300">{{ $pengajuan->user->name ?? 'Unknown' }}</td>
                                        <td class="py-3 uppercase text-blue-300">{{ $pengajuan->status }}</td>
                                        <td class="py-3">{{ $pengajuan->tanggal_berlaku ? $pengajuan->tanggal_berlaku->format('d M Y') : 'N/A' }}</td>
                                        <td class="py-3">
                                            <a href="{{ route('admin.documents.show', $pengajuan->id) }}" class="text-blue-400 hover:underline">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <p>No pending documents.</p>
                    </div>
                @endif
            </div>

            <div class="glass p-6 rounded-2xl">
                <h2 class="text-lg font-semibold mb-4 text-purple-300">Recent Activity</h2>

                @if($recentActivities->count() > 0)
                    <ul class="space-y-3 text-sm text-purple-200">
                        @foreach($recentActivities as $activity)
                            <li class="pb-3 border-b border-white/10">
                                <p>
                                    <strong>{{ $activity->reviewer->name ?? $activity->pengajuan->user->name ?? 'System' }}</strong>
                                    {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                    <strong>{{ $activity->pengajuan->judul ?? 'Unknown' }}</strong>
                                </p>
                                @if($activity->note)
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity->note }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <p>No recent activity yet.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

</body>
</html>
