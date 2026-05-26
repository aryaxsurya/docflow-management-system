<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\ReviewLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewerController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Level reviewer (1,2,3)
        $reviewerLevel = $user->reviewer_level;

        // Status dokumen sesuai level
        $reviewStatus = 'review' . $reviewerLevel;

        // Filter dokumen berdasarkan level reviewer saat ini
        $pengajuanList = Pengajuan::with('user')
            ->where('current_reviewer_level', $reviewerLevel)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviewer.index', [
            'pengajuanList' => $pengajuanList,
            'reviewLevel'   => $reviewerLevel,
        ]);
    }

    public function history()
    {
        $user = auth()->user();

        $reviewLogs = ReviewLog::with('pengajuan')
            ->where('reviewer_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('reviewer.history', [
            'reviewLogs' => $reviewLogs
        ]);
    }

    /**    public function deadlines()
    *{
    *    $now = Carbon::now();

    *        $pengajuanList = Pengajuan::query()
    *        ->whereNotNull('tanggal_berlaku')          // hanya yang punya deadline
    *        ->where('tanggal_berlaku', '>=', $now)     // hanya yang belum lewat
    *        ->orderBy('tanggal_berlaku', 'asc')        // terdekat dulu
    *        ->paginate(10);

    *    return view('reviewer.deadlines.index', [
    *        'pengajuanList' => $pengajuanList,
    *    ]);
    *}
        */

    public function deadlines()
    {
        $user = auth()->user();
        $reviewerLevel = (int) ($user->reviewer_level ?? 0);
        $now = Carbon::now();
        $limit = $now->copy()->addDays(7);

        $pengajuanList = Pengajuan::with('user')
            ->whereNotNull('tanggal_berlaku')
            ->where('status', 'review' . $reviewerLevel)
            ->where('current_reviewer_level', $reviewerLevel)
            ->where('tanggal_berlaku', '<=', $limit) // termasuk yang sudah lewat dan yang dalam 7 hari
            ->orderBy('tanggal_berlaku', 'asc')
            ->paginate(10);

        return view('reviewer.deadlines.index', [
            'pengajuanList' => $pengajuanList,
        ]);
    }



    /**
     * =========================
     * BUKA HALAMAN REVIEW (LIHAT SAJA)
     * =========================
     */
    public function show(Pengajuan $pengajuan)
    {
        $this->authorizeAction($pengajuan);

        // catat waktu mulai review (sekali saja)
        if (!session()->has("review_start_{$pengajuan->id}")) {
            session([
                "review_start_{$pengajuan->id}" => now()
            ]);
        }

        return view('reviewer.review', [
            'pengajuan' => $pengajuan,
            'logs' => $pengajuan->reviewLogs()->with('reviewer')->latest()->get()
        ]);
    }

    /**
     * =========================
     * APPROVE
     * =========================
     */
    public function approve(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeAction($pengajuan);

        DB::transaction(function () use ($request, $pengajuan) {

            ReviewLog::create([
                'pengajuan_id'   => $pengajuan->id,
                'reviewer_id'    => auth()->id(),
                'reviewer_level' => auth()->user()->reviewer_level,
                'action'         => 'approve',
                'note'           => $request->note,
                'started_at'     => session("review_start_{$pengajuan->id}"),
                'finished_at'    => now(),
            ]);

            // naik ke reviewer berikutnya atau selesai
            if ($pengajuan->current_reviewer_level < 3) {
                $next = $pengajuan->current_reviewer_level + 1;

                $pengajuan->update([
                    'current_reviewer_level' => $next,
                    'status' => 'review' . $next,
                    'review_deadline' => now()->addDays(2)
                ]);
            } else {
                $pengajuan->update([
                    'status' => 'approved',
                    'approved_at' => now()
                ]);
            }
        });

        session()->forget("review_start_{$pengajuan->id}");

        return redirect()->route('reviewer.index')
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    /**
     * =========================
     * REQUEST CHANGES
     * =========================
     */
    public function request(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeAction($pengajuan);

        ReviewLog::create([
            'pengajuan_id'   => $pengajuan->id,
            'reviewer_id'    => auth()->id(),
            'reviewer_level' => auth()->user()->reviewer_level,
            'action'         => 'request_changes',
            'note'           => $request->note,
            'started_at'     => session("review_start_{$pengajuan->id}"),
            'finished_at'    => now(),
        ]);

        $pengajuan->update([
            'status' => 'draft',
            'current_reviewer_level' => null,
            'review_deadline' => null
        ]);

        session()->forget("review_start_{$pengajuan->id}");

        return redirect()->route('reviewer.index')
            ->with('warning', 'Dokumen dikembalikan ke draft.');
    }

    /**
     * =========================
     * REJECT
     * =========================
     */
    public function reject(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeAction($pengajuan);

        ReviewLog::create([
            'pengajuan_id'   => $pengajuan->id,
            'reviewer_id'    => auth()->id(),
            'reviewer_level' => auth()->user()->reviewer_level,
            'action'         => 'reject',
            'note'           => $request->note,
            'started_at'     => session("review_start_{$pengajuan->id}"),
            'finished_at'    => now(),
        ]);

        $pengajuan->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        session()->forget("review_start_{$pengajuan->id}");

        return redirect()->route('reviewer.index')
            ->with('error', 'Dokumen ditolak.');
    }

    /**
     * =========================
     * AUTH: BOLEH MELAKUKAN AKSI
     * =========================
     */
    private function authorizeAction(Pengajuan $pengajuan)
    {
        $user = auth()->user();

        // Normalize reviewer level comparison (cast to int) and
        // compare status case-insensitively to allow 'Review1' or 'review1'.
        $userLevel = (int) ($user->reviewer_level ?? 0);
        $pengajuanLevel = (int) ($pengajuan->current_reviewer_level ?? 0);
        $expectedStatus = 'review' . $userLevel;

        if (
            $user->role !== 'reviewer' ||
            $userLevel !== $pengajuanLevel ||
            strtolower($pengajuan->status) !== $expectedStatus
        ) {
            abort(403, 'Anda tidak berhak melakukan aksi review ini.');
        }
    }
}
