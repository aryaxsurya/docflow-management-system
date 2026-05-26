<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\ReviewLog;
use App\Models\User;


class DashboardController extends Controller
{

     /**
     * =========================
     * DASHBOARD USER
     * =========================
     */
    public function userDashboard()
    {
        $userId = auth()->id();

        // 1️⃣ FETCH 5 PENGAJUAN TERBARU MILIK USER (dengan eager loading)
        $latestPengajuan = Pengajuan::where('user_id', $userId)
            ->with('reviewLogs')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 2️⃣ STATISTIK BERDASARKAN USER (optimize: 1 query dengan counts)
        $statsData = Pengajuan::where('user_id', $userId)
            ->selectRaw('
                COUNT(CASE WHEN status IN ("review1", "review2", "review3") THEN 1 END) as aktif,
                COUNT(CASE WHEN status = "approved" THEN 1 END) as approved,
                COUNT(CASE WHEN status = "rejected" THEN 1 END) as rejected
            ')
            ->first();

        $stats = [
            'aktif' => $statsData->aktif ?? 0,
            'approved' => $statsData->approved ?? 0,
            'rejected' => $statsData->rejected ?? 0,
        ];

        // 3️⃣ RETURN VIEW
        return view('dashboard.user', [
            'latestPengajuan' => $latestPengajuan,
            'stats' => $stats,
        ]);
    }

     /**
     * =========================
     * DASHBOARD REVIEWER
     * =========================
     */
    public function reviewerDashboard()
    {
        $user = auth()->user();

        // reviewer level sebagai angka (1,2,3)
        $level = (int) ($user->reviewer_level ?? 1);
        $reviewStatus = 'review' . $level;

        // 1️⃣ Dokumen menunggu review + eager load user
        $latestPengajuan = Pengajuan::with('user')
            ->where('status', $reviewStatus)
            ->where('current_reviewer_level', $level)
            ->orderBy('created_at', 'asc')
            ->take(6)
            ->get();

        // 2️⃣ Statistik spesifik reviewer (optimize: 1 query)
        $statsData = Pengajuan::where('current_reviewer_level', $level)
            ->selectRaw('
                COUNT(CASE WHEN status = ? THEN 1 END) as pending,
                COUNT(CASE WHEN tanggal_berlaku > NOW() AND tanggal_berlaku <= DATE_ADD(NOW(), INTERVAL 7 DAY) THEN 1 END) as near_deadline,
                COUNT(CASE WHEN tanggal_berlaku < NOW() THEN 1 END) as overdue
            ', [$reviewStatus])
            ->first();

        $completedCount = ReviewLog::where('reviewer_id', $user->id)->count();

        return view('dashboard.reviewer', [
            'latestPengajuan' => $latestPengajuan,
            'pendingReviews' => $statsData->pending ?? 0,
            'nearDeadline'   => $statsData->near_deadline ?? 0,
            'completedCount' => $completedCount,
            'reviewerName'   => $user->name,
            'reviewLevel'    => $reviewStatus,
            'overdueCount'   => $statsData->overdue ?? 0,
        ]);
    }



    /**
     * =========================
     * DASHBOARD ADMIN
     * =========================
     */
    public function adminDashboard()
    {
        // 1️⃣ STATISTIK SUMMARY
        $pendingUsers = User::where('status', 'pending')->count();
        $pendingDocs = Pengajuan::whereIn('status', ['submitted', 'review1', 'review2', 'review3'])->count();
        $signingProcess = Pengajuan::where('status', 'approved')->count();
        $signedDocs = Pengajuan::where('status', 'signed')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        // 2️⃣ PENGAJUAN MENUNGGU YANG PERLU ACTION (ambil 10 terbaru)
        $recentPengajuan = Pengajuan::with('user')
            ->whereIn('status', ['submitted', 'review1', 'review2', 'review3', 'approved'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 3️⃣ RECENT ACTIVITY dari Review Logs (ambil 10 terbaru)
        $recentActivities = ReviewLog::with(['pengajuan', 'pengajuan.user', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 4️⃣ DATA TAMBAHAN
        $totalUsers = User::count();

        return view('dashboard.admin', [
            'pendingUsers' => $pendingUsers,
            'pendingDocs' => $pendingDocs,
            'signedDocs' => $signedDocs,
            'signingProcess' => $signingProcess,
            'totalUsers' => $totalUsers,
            'recentPengajuan' => $recentPengajuan,
            'recentActivities' => $recentActivities,
        ]);
    }


}
