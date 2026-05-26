<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // =========================
    // LIST USER MENUNGGU APPROVAL
    // =========================
    public function userApprovals()
    {
        $users = User::where('status', 'pending')->get();

        return view('admin.user-approvals', compact('users'));
    }

    // =========================
    // APPROVE USER
    // =========================
    public function approveUser($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'active'; // sesuaikan dengan DB kamu
        $user->save();

        return back()->with('success', 'User berhasil di-approve');
    }

    // =========================
    // REJECT USER
    // =========================
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'rejected'; // sesuaikan dengan DB kamu
        $user->save();

        return back()->with('success', 'User berhasil ditolak');
    }
}