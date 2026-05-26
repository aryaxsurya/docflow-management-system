<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil user.
     */
    public function edit()
    {
        return view('user.profile.edit');
    }

    /**
     * Update data profil user.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'password'  => 'nullable|min:6',
            'photo'     => 'nullable|image|max:2048',
            'about'  => 'nullable|string|max:2000',
        ]);

        // Upload foto
        if ($request->hasFile('photo')) {
            $path = $request->photo->store('profile', 'public');
            $user->photo_url = '/storage/' . $path;
        }

        // Update password jika diisi
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Update nama & email
        $user->name  = $request->name;
        $user->email = $request->email;

        // Update About Me 
        
        $user->about = $request->about;

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function show()
    {
        $user = auth()->user();
        return view('user.profile.show', compact('user'));
    }

}
