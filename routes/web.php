<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Admin\DocumentApprovalController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ReviewerController;

Route::get('/', function () {
    return view('welcome');
});

// ================= LOGIN =================
Route::get('/login/user', function () { return view('auth.login-user'); });
Route::post('/login/user', [LoginController::class, 'userLogin'])->name('login.user.store');

Route::get('/login/reviewer', function () { return view('auth.login-reviewer'); });
Route::post('/login/reviewer', [LoginController::class, 'reviewerLogin'])->name('login.reviewer.store');

Route::get('/login/admin', function () { return view('auth.login-admin'); });
Route::post('/login/admin', [LoginController::class, 'adminLogin'])->name('login.admin.store');

// ================= VERIFICATION =================
Route::get('/verification/pending', function () { return view('auth.verification-pending'); })->name('verification.pending');

Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'reviewer') {
        return redirect()->route('dashboard.reviewer');
    }

    return redirect()->route('dashboard.user');
})->name('dashboard');

// ================= DASHBOARD =================
Route::get('/dashboard/user', [DashboardController::class, 'userDashboard'])->name('dashboard.user');
Route::get('/dashboard/reviewer', [DashboardController::class, 'reviewerDashboard'])->name('dashboard.reviewer');
Route::middleware(['auth', 'role:admin'])->get('/dashboard/admin', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard.admin');

// ================= USER PENGAJUAN =================
Route::middleware('auth')->prefix('user/pengajuan')->group(function () {
    Route::get('/', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::post('/autosave', [PengajuanController::class, 'autosave'])->name('pengajuan.autosave');
    Route::get('/{id}/edit', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/{id}', [PengajuanController::class, 'update'])->name('pengajuan.update');
    Route::get('/{id}', [PengajuanController::class, 'show'])->name('pengajuan.show');
});

// ================= REVIEWER =================
Route::middleware('auth')->prefix('reviewer/pengajuan')->group(function () {
    Route::get('/', [ReviewerController::class, 'index'])->name('reviewer.index');
    Route::get('/{pengajuan}', [ReviewerController::class, 'show'])->name('reviewer.show');
    Route::post('/{pengajuan}/review', [ReviewerController::class, 'submit'])->name('reviewer.review');
    Route::post('/{pengajuan}/approve', [ReviewerController::class, 'approve'])->name('reviewer.approve');
    Route::post('/{pengajuan}/request-changes', [ReviewerController::class, 'request'])->name('reviewer.request');
    Route::post('/{pengajuan}/reject', [ReviewerController::class, 'reject'])->name('reviewer.reject');
});

Route::middleware(['auth'])->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/riwayat', [ReviewerController::class, 'history'])->name('history');
    Route::get('/reviews', [ReviewerController::class, 'index'])->name('reviews.index');
    Route::get('/review/{pengajuan}', [ReviewerController::class, 'show'])->name('review.show');
    Route::get('/deadlines', [ReviewerController::class, 'deadlines'])->name('deadlines');
});

Route::get('/review/{document}', [ReviewController::class, 'show'])->name('review.show');

// ================= ADMIN =================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('user.approvals');
    Route::post('/user-approvals/{id}/approve', [UserApprovalController::class, 'approve'])->name('user.approve');
    Route::post('/user-approvals/{id}/reject', [UserApprovalController::class, 'reject'])->name('user.reject');

    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/draft', [DocumentApprovalController::class, 'draft'])->name('draft');
        Route::get('/review', [DocumentApprovalController::class, 'review'])->name('review');
        Route::get('/approval', [DocumentApprovalController::class, 'approval'])->name('approval');
        Route::get('/signing', [DocumentApprovalController::class, 'signing'])->name('signing');
        Route::get('/archive', [DocumentApprovalController::class, 'archive'])->name('archive');

        Route::redirect('/drafts', '/admin/documents/draft');
        Route::redirect('/under-review', '/admin/documents/review');
        Route::redirect('/waiting-approval', '/admin/documents/approval');
        Route::redirect('/signing-process', '/admin/documents/signing');

        Route::get('/{id}', [DocumentApprovalController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [DocumentApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [DocumentApprovalController::class, 'reject'])->name('reject');
    });

    Route::get('/users/suspended', [AdminDashboardController::class, 'suspendedUsers'])->name('users.suspended');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.delete');

    Route::get('/audit-log', [AdminDashboardController::class, 'auditLog'])->name('audit-log');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user/profile', [UserProfileController::class, 'edit'])->name('user.profile');
Route::post('/user/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
Route::get('/user/profile/show', [UserProfileController::class, 'show'])->name('user.profile.show');

Route::middleware(['auth', 'role:reviewer'])->group(function () {
    Route::get('/review', [ReviewController::class, 'index']);
});

require __DIR__ . '/auth.php';
