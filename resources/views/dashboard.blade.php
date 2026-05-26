<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Document Workflow</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>

<body class="bg-gray-100">

    <!-- Sidebar + Content Wrapper -->
    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-xl border-r hidden md:block">

            <div class="px-6 py-6">
                <h1 class="text-2xl font-bold text-gray-800">Workflow</h1>
                <p class="text-gray-500 text-sm -mt-1">Dashboard</p>
            </div>

            <nav class="px-4 text-gray-700 mt-4 space-y-2">

                <a href="/dashboard"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-600 text-white shadow">
                    <span>🏠</span> Dashboard
                </a>

                <a href="/documents/create"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <span>📝</span> Buat Dokumen
                </a>

                <a href="/documents"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <span>📄</span> Semua Dokumen
                </a>

                <a href="/documents/review"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <span>🔍</span> Dokumen Review
                </a>

                <a href="/settings"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <span>⚙️</span> Pengaturan
                </a>

            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6">

            <!-- TOP BAR -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-3xl font-bold">Selamat Datang 👋</h2>
                    <p class="text-gray-600">Ini adalah ringkasan aktivitas workflow Anda.</p>
                </div>

                <div class="flex items-center gap-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                        + Dokumen Baru
                    </button>

                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                </div>
            </div>

            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-4xl">📄</div>
                    <h3 class="text-lg font-bold mt-4">Total Dokumen</h3>
                    <p class="text-3xl font-bold mt-2 text-blue-700">128</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-4xl">✏️</div>
                    <h3 class="text-lg font-bold mt-4">Draft</h3>
                    <p class="text-3xl font-bold mt-2 text-yellow-600">8</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-4xl">👀</div>
                    <h3 class="text-lg font-bold mt-4">Menunggu Review</h3>
                    <p class="text-3xl font-bold mt-2 text-purple-600">5</p>
                </div>

            </div>

            <!-- TABLE SECTION -->
            <div class="bg-white p-6 rounded-xl shadow">

                <h3 class="text-xl font-bold mb-4">📌 Dokumen Terbaru</h3>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left text-gray-600 text-sm">
                            <th class="p-3">Judul</th>
                            <th class="p-3">Unit</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <!-- Example Row -->
                        <tr class="border-b">
                            <td class="p-3">SOP Keamanan Data</td>
                            <td class="p-3">IT Department</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                    Draft
                                </span>
                            </td>
                            <td class="p-3">2025-01-12</td>
                            <td class="p-3">
                                <a href="#" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="p-3">Kebijakan Backup</td>
                            <td class="p-3">IT</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-xs bg-purple-100 text-purple-700">
                                    Review
                                </span>
                            </td>
                            <td class="p-3">2025-01-10</td>
                            <td class="p-3">
                                <a href="#" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>

                        <tr>
                            <td class="p-3">Panduan Kerja Baru</td>
                            <td class="p-3">HR</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Approved
                                </span>
                            </td>
                            <td class="p-3">2025-01-08</td>
                            <td class="p-3">
                                <a href="#" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

        </main>

    </div>

</body>
</html>
