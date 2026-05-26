<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withInput()->with('error', 'User tidak ditemukan.');
        }

        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withInput()->with('error', 'Email atau password salah.');
        }

        if ($user->status === 'pending') {
            Auth::logout();
            return back()->withInput()->with('error', 'Akun Anda masih dalam proses verifikasi. Silakan tunggu persetujuan admin.');
        }

        if (! $user->isUser()) {
            Auth::logout();
            return back()->withInput()->with('error', 'Akun bukan role user.');
        }

        return redirect()->route('dashboard.user');
    }

    public function reviewerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withInput()->with('error', 'User tidak ditemukan.');
        }

        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withInput()->with('error', 'Email atau password salah.');
        }

        if ($user->status === 'pending') {
            Auth::logout();
            return back()->withInput()->with('error', 'Akun Anda masih dalam proses verifikasi. Silakan tunggu persetujuan admin.');
        }

        if (! $user->isReviewer()) {
            Auth::logout();
            return back()->withInput()->with('error', 'Akun bukan role reviewer.');
        }

        return redirect()->route('dashboard.reviewer');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withInput()->with('error', 'User tidak ditemukan.');
        }

        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withInput()->with('error', 'Email atau password salah.');
        }

        if ($user->status === 'pending') {
            Auth::logout();
            return back()->withInput()->with('error', 'Akun Anda masih dalam proses verifikasi. Silakan tunggu persetujuan admin.');
        }

        if (! $user->isAdmin()) {
            Auth::logout();
            return back()->withInput()->with('error', 'Akun bukan role admin.');
        }

        return redirect()->route('admin.dashboard');
    }
}
