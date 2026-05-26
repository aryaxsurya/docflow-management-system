<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\ReviewLog;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->count();
        $pendingDocs = Pengajuan::where('status', 'approved')->count();
        $signingProcess = Pengajuan::where('status', 'signing')->count();
        $archivedThisMonth = Pengajuan::whereIn('status', ['signed', 'archived'])
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        $recentPengajuan = Pengajuan::with('user')
            ->whereIn('status', ['review1', 'review2', 'review3', 'approved', 'signing'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $recentActivities = ReviewLog::with(['pengajuan', 'pengajuan.user', 'reviewer'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('dashboard.admin', [
            'pendingUsers' => $pendingUsers,
            'pendingDocs' => $pendingDocs,
            'signedDocs' => $archivedThisMonth,
            'signingProcess' => $signingProcess,
            'recentPengajuan' => $recentPengajuan,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function suspendedUsers()
    {
        $suspendedUsers = User::where('status', 'suspended')
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('admin.users.suspended', [
            'users' => $suspendedUsers,
        ]);
    }

    public function auditLog()
    {
        $logs = ReviewLog::with(['pengajuan', 'pengajuan.user', 'reviewer'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.audit-log', [
            'logs' => $logs,
        ]);
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
