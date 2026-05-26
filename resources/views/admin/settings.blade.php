<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Admin Panel</title>
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
                <h1 class="text-3xl font-bold text-purple-300">⚙️ Settings</h1>
                <p class="text-purple-200 text-sm mt-2">Pengaturan sistem dan konfigurasi</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- System Settings -->
                <div class="glass p-6 rounded-2xl">
                    <h2 class="text-lg font-semibold text-purple-300 mb-4">🔧 System Settings</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-purple-200 mb-2">Application Name</label>
                            <input type="text" value="Document Workflow System" 
                                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm text-purple-200 mb-2">Timezone</label>
                            <select class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-sm">
                                <option>Asia/Jakarta</option>
                                <option>Asia/Bangkok</option>
                                <option>UTC</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-purple-200 mb-2">Items per Page</label>
                            <input type="number" value="15" 
                                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-sm">
                        </div>

                        <button class="w-full mt-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-white font-semibold">
                            Save Settings
                        </button>
                    </div>
                </div>

                <!-- Review Settings -->
                <div class="glass p-6 rounded-2xl">
                    <h2 class="text-lg font-semibold text-purple-300 mb-4">📋 Review Settings</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-purple-200 mb-2">Number of Review Levels</label>
                            <input type="number" value="3" 
                                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm text-purple-200 mb-2">Default Review Deadline (days)</label>
                            <input type="number" value="7" 
                                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm text-purple-200 mb-2">Notification Email</label>
                            <input type="email" value="admin@system.local" 
                                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-sm">
                        </div>

                        <button class="w-full mt-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-white font-semibold">
                            Save Settings
                        </button>
                    </div>
                </div>

            </div>

            <!-- Danger Zone -->
            <div class="glass p-6 rounded-2xl mt-8 border border-red-500/30">
                <h2 class="text-lg font-semibold text-red-400 mb-4">⚠️ Danger Zone</h2>
                
                <div class="space-y-3">
                    <p class="text-sm text-gray-300">Operasi berikut dapat menyebabkan kehilangan data</p>
                    
                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white font-semibold text-sm">
                        Clear Cache
                    </button>
                    
                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white font-semibold text-sm">
                        Reset System
                    </button>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
