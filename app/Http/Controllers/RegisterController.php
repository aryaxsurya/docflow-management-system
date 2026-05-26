<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
   public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,reviewer',
        ]);

        // Buat user tapi set status menunggu approval admin
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status' => 'pending', // tambahkan kolom ini di users table
        ]);

        return redirect()->route('register')
            ->with('success', 'Pendaftaran berhasil! Menunggu persetujuan Admin.');
    }

        
}
