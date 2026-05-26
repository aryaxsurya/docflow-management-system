<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Review Dokumen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --bg: #0a1124;
            --glass: rgba(255,255,255,0.08);
            --border: rgba(255,255,255,0.12);
            --text: #e6eeff;
            --primary: #818cf8;
            --green: #22c55e;
            --yellow: #eab308;
            --red: #ef4444;
        }

        * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
        }

        .container {
            padding: 32px;
        }

        .glass {
            background: var(--glass);
            border: 1px solid var(--border);
            backdrop-filter: blur(14px);
            border-radius: 16px;
        }

        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        h1, h2, h3 {
            margin: 0 0 12px;
            color: var(--primary);
        }

        .meta {
            font-size: 14px;
            opacity: 0.85;
            margin-bottom: 16px;
        }

        iframe {
            width: 100%;
            height: 650px;
            border-radius: 12px;
            border: none;
            background: #000;
        }

        textarea {
            width: 100%;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px;
            color: var(--text);
            resize: vertical;
            min-height: 90px;
        }

        textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text);
        }

        .btn-approve {
            border-color: rgba(34,197,94,0.5);
            color: var(--green);
        }

        .btn-request {
            border-color: rgba(234,179,8,0.5);
            color: var(--yellow);
        }

        .btn-reject {
            border-color: rgba(239,68,68,0.5);
            color: var(--red);
        }

        button:hover {
            background: rgba(255,255,255,0.08);
        }

        .log {
            border-bottom: 1px solid var(--border);
            padding: 12px 0;
        }

        .log:last-child {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            border: 1px solid var(--border);
            margin-right: 6px;
        }

        .approve { color: var(--green); }
        .request { color: var(--yellow); }
        .reject { color: var(--red); }

        .deadline {
            color: var(--red);
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="glass" style="padding:20px;margin-bottom:24px;">
        <h1>📥 Dokumen Menunggu Review ({{ $reviewLevel }})</h1>
    </div>

    <!-- LIST PENGAJUAN -->
    <div class="glass" style="padding:20px;">
     @forelse($latestPengajuan as $pengajuan)
            <div class="glass" style="padding:14px;margin-bottom:12px;">
                <strong>{{ $pengajuan->judul }}</strong><br>
                Status: {{ strtoupper($pengajuan->status) }}<br>

                Deadline:
                @if($pengajuan->review_deadline)
                    {{ $pengajuan->review_deadline->format('d M Y H:i') }}
                @else
                    -
                @endif

                <br><br>

                <a href="{{ route('reviewer.show', $pengajuan->id) }}"
                   style="color:#818cf8;">
                    🔍 Review Dokumen
                </a>
            </div>
        @empty
            <p>Tidak ada dokumen untuk direview.</p>
        @endforelse
    </div>

    <!-- CONTENT -->
    <div class="grid">

        <!-- DOKUMEN -->
        <div class="glass" style="padding:20px;">
            <h2>Isi Dokumen</h2>
            <iframe src="{{ asset('storage/'.$pengajuan->file_path) }}"></iframe>
        </div>

        <!-- PANEL AKSI -->
        <div class="glass" style="padding:20px;">
            <h2>Aksi Reviewer</h2>

            <!-- APPROVE -->
            <form method="POST" action="{{ route('reviewer.approve',$pengajuan) }}">
                @csrf
                <textarea name="note" placeholder="Catatan approve..."></textarea>
                <button class="btn-approve">✅ Approve</button>
            </form>

            <!-- REQUEST -->
            <form method="POST" action="{{ route('reviewer.request',$pengajuan) }}">
                @csrf
                <textarea name="note" placeholder="Catatan revisi..."></textarea>
                <button class="btn-request">🔁 Request Changes</button>
            </form>

            <!-- REJECT -->
            <form method="POST" action="{{ route('reviewer.reject',$pengajuan) }}">
                @csrf
                <textarea name="note" placeholder="Alasan reject..."></textarea>
                <button class="btn-reject">❌ Reject</button>
            </form>
        </div>

    </div>

    <!-- RIWAYAT -->
    <div class="glass" style="padding:20px;margin-top:24px;">
        <h2>Riwayat Review</h2>

        @forelse($logs as $log)
            <div class="log">
                <div>
                    <span class="badge">Review {{ $log->reviewer_level }}</span>
                    <strong>{{ $log->reviewer->name }}</strong>
                </div>

                <div class="
                    @if($log->action=='approve') approve
                    @elseif($log->action=='request_changes') request
                    @else reject @endif
                ">
                    {{ strtoupper($log->action) }}
                </div>

                <div class="meta">
                    {{ $log->created_at->format('d M Y H:i') }}
                </div>

                <div>{{ $log->note }}</div>
            </div>
        @empty
            <p class="meta">Belum ada riwayat review.</p>
        @endforelse
    </div>

</div>

</body>
</html>
