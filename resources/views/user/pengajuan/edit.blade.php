<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengajuan Dokumen</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Inter", sans-serif;
            background: #0a1124;
            color: #e6eeff;
        }

        .container {
            padding: 40px;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
            max-width: 900px;
            margin: auto;
            padding: 32px;
            border-radius: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            color: #7ec3ff;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        .btn-back { background: #555; }
        .btn-back:hover { background: #666; }

        .btn-save { background: #1e63d3; }
        .btn-save:hover { background: #144ea5; }

        .btn-cancel { background: #555; }
        .btn-cancel:hover { background: #666; }

        input, textarea, select {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.15);
            color: #e6eeff;
            font-size: 15px;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .message-error {
            padding: 16px;
            background: rgba(255,0,0,0.15);
            border: 1px solid rgba(255,80,80,0.5);
            color: #ffb4b4;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .message-success {
            padding: 16px;
            background: rgba(0,180,70,0.15);
            border: 1px solid rgba(0,180,70,0.5);
            color: #b6ffca;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .file-link {
            color: #7ec3ff;
            text-decoration: underline;
        }

        .btn-row {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="glass">

        <!-- HEADER -->
        <div class="header">
            <div class="title">✏️ Edit Pengajuan Dokumen</div>

            <a href="{{ route('pengajuan.index') }}" class="btn btn-back">
                ← Kembali
            </a>
        </div>

        <!-- FORM -->
        <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ERROR -->
            @if ($errors->any())
                <div class="message-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- SUCCESS -->
            @if (session('success'))
                <div class="message-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- JUDUL -->
            <label>Judul Dokumen</label>
            <input type="text" name="judul" value="{{ $pengajuan->judul }}" required>

            <!-- JENIS -->
            <label>Jenis Dokumen</label>
            <input type="text" name="jenis" value="{{ $pengajuan->jenis }}" required>

            <!-- UNIT -->
            <label>Unit Kerja</label>
            <input type="text" name="unit_kerja" value="{{ $pengajuan->unit_kerja }}" required>

            <!-- DESKRIPSI -->
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" required>{{ $pengajuan->deskripsi }}</textarea>

            <!-- TANGGAL -->
            <label>Tanggal Berlaku</label>
            <input type="date" name="tanggal_berlaku" value="{{ $pengajuan->tanggal_berlaku }}" required>

            <!-- FILE LAMA -->
            <label>Lampiran Lama:</label>
            @if ($pengajuan->lampiran)
                <a href="{{ asset('storage/' . $pengajuan->lampiran) }}" target="_blank" class="file-link">
                    📎 Lihat lampiran sebelumnya
                </a>
            @else
                <p style="opacity: 0.6;">Tidak ada lampiran</p>
            @endif

            <!-- FILE BARU -->
            <label>Upload Lampiran Baru (opsional)</label>
            <input type="file" name="lampiran">

            <!-- BUTTONS -->
            <div class="btn-row">
                <a href="{{ route('pengajuan.index') }}" class="btn btn-cancel">← Batal</a>

                <button type="submit" class="btn btn-save">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

</body>
</html>
