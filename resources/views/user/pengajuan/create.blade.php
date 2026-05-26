<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengajuan Dokumen</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: "Inter", sans-serif;
            background: #0a1124;
            color: #e6eeff;
        }
        .glass {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
        }
    </style>
</head>

<body class="p-10">

    <div class="max-w-3xl mx-auto glass p-8 rounded-2xl">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-300">📄 Buat Pengajuan Dokumen</h1>
            <a href="{{ route('dashboard.user') }}" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-white transition">
                ← Kembali
            </a>
        </div>

        <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" id="formPengajuan">
            @csrf

            <input type="hidden" id="draft_id">

            <!-- ERROR MESSAGE -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-500/20 border border-red-400/50 rounded-xl text-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-500/20 border border-red-400/50 rounded-xl text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- JUDUL -->
            <label class="block mb-2 font-semibold">Judul Dokumen</label>
            <input type="text" name="judul" id="judul"
                class="w-full p-3 rounded-lg bg-white/10 mb-4" required>

            <!-- JENIS -->
            <label class="block mb-2 font-semibold">Jenis Dokumen</label>
            <select name="jenis" id="jenis" class="w-full p-3 rounded-lg bg-white/10 mb-4" required>
                <option value="">-- pilih jenis --</option>
                <option>Surat Keputusan</option>
                <option>Memo</option>
                <option>Standar Operasional</option>
                <option>Buku Pengetahuan</option>
                <option>Novel</option>
                <option>Referensi</option>
            </select>

            <!-- UNIT -->
            <label class="block mb-2 font-semibold">Unit Kerja</label>
            <input type="text" name="unit_kerja" id="unit_kerja"
                class="w-full p-3 rounded-lg bg-white/10 mb-4" required>

            <!-- DESKRIPSI -->
            <label class="block mb-2 font-semibold">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi"
                class="w-full p-3 rounded-lg bg-white/10 mb-4" rows="4" required></textarea>

            <!-- TANGGAL -->
            <label class="block mb-2 font-semibold">Tanggal Berlaku</label>
            <input type="date" name="tanggal_berlaku" id="tanggal_berlaku"
                class="w-full p-3 rounded-lg bg-white/10 mb-4" required>

            <!-- LAMPIRAN -->
            <label class="block mb-2 font-semibold">Upload Lampiran</label>
            <input type="file" name="lampiran" class="mb-6">

            <div class="flex justify-between">
                <button type="button" id="btnAutosave"
                    class="bg-yellow-600 px-4 py-2 rounded-lg text-white">
                    Simpan Draft
                </button>

                <button type="submit"
                    class="bg-blue-600 px-4 py-2 rounded-lg text-white">
                    Submit Pengajuan
                </button>
            </div>

        </form>
    </div>

    <script>
        // AUTOSAVE via AJAX
        document.getElementById('btnAutosave').addEventListener('click', function() {
            let formData = new FormData();

            formData.append('draft_id', document.getElementById('draft_id').value);
            formData.append('judul', document.getElementById('judul').value);
            formData.append('jenis', document.getElementById('jenis').value);
            formData.append('unit_kerja', document.getElementById('unit_kerja').value);
            formData.append('deskripsi', document.getElementById('deskripsi').value);
            formData.append('tanggal_berlaku', document.getElementById('tanggal_berlaku').value);

            fetch("{{ route('pengajuan.autosave') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert("Draft tersimpan otomatis");
                document.getElementById('draft_id').value = data.draft_id;
            });
        });
    </script>

</body>

</html>
