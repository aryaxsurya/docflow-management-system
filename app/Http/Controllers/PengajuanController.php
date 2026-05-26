<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\PengajuanBaru;

class PengajuanController extends Controller
{
    // LIST RIWAYAT PENGAJUAN USER
    public function index()
    {
        $pengajuan = Pengajuan::where('user_id', Auth::id())->latest()->get();
        return view('user.pengajuan.index', compact('pengajuan'));
    }

    // Detail dari dokumen
    public function show($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        return view('user.pengajuan_detail', compact('pengajuan'));
    }

    // EDIT - Menampilkan form edit
    public function edit($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // pastikan user hanya bisa edit pengajuannya sendiri
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        return view('user.pengajuan.edit', compact('pengajuan'));
    }

    // UPDATE - Menyimpan perubahan
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required',
                'jenis' => 'required',
                'unit_kerja' => 'required',
                'deskripsi' => 'required',
                'tanggal_berlaku' => 'required|date',
                'lampiran' => 'nullable|file|max:2097152'
            ]);

            $pengajuan = Pengajuan::findOrFail($id);

            if ($pengajuan->user_id !== Auth::id()) {
                abort(403, 'Unauthorized.');
            }

            // update data
            $pengajuan->judul = $request->judul;
            $pengajuan->jenis = $request->jenis;
            $pengajuan->unit_kerja = $request->unit_kerja;
            $pengajuan->deskripsi = $request->deskripsi;
            $pengajuan->tanggal_berlaku = $request->tanggal_berlaku;

            // jika ada file baru
            if ($request->hasFile('lampiran')) {
                if ($pengajuan->lampiran) {
                    Storage::disk('public')->delete($pengajuan->lampiran);
                }

                $pengajuan->lampiran = $request->file('lampiran')->store('lampiran', 'public');
            }

            $pengajuan->save();

            return redirect()->route('pengajuan.index')->with('success','Pengajuan berhasil diperbarui!');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
       }
    }


    // FORM CREATE
    public function create()
    {
        return view('user.pengajuan.create');
    }

    // STORE SUBMIT
    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required',
                'jenis' => 'required',
                'unit_kerja' => 'required',
                'deskripsi' => 'required',
                'tanggal_berlaku' => 'required|date',
                'lampiran' => 'nullable|file|max:2097152'
            ]);

            $path = null;
            if ($request->hasFile('lampiran')) {
                $path = $request->file('lampiran')->store('lampiran', 'public');
            }

            $pengajuan = Pengajuan::create([
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'jenis' => $request->jenis,
                'unit_kerja' => $request->unit_kerja,
                'deskripsi' => $request->deskripsi,
                'tanggal_berlaku' => $request->tanggal_berlaku,
                'lampiran' => $path,
                'status' => 'review1',
                'current_reviewer_level' => 1,
            ]);

            // NOTIFIKASI KE REVIEWER LEVEL 1
            $reviewers = User::where('role', 'reviewer')->get();
            if ($reviewers->count() > 0) {
                Notification::send($reviewers, new PengajuanBaru($pengajuan));
            }

            return redirect()->route('pengajuan.index')->with('success','Pengajuan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    // AUTOSAVE DRAFT
    public function autosave(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'draft_id' => 'nullable|integer',
                'judul' => 'required|string|max:255',
                'jenis' => 'nullable|string|max:100',
                'unit_kerja' => 'nullable|string|max:100',
                'deskripsi' => 'nullable|string',
                'tanggal_berlaku' => 'nullable|date'
            ]);

            $draft = Pengajuan::updateOrCreate(
                [
                    'id' => $request->draft_id
                ],
                [
                    'user_id' => Auth::id(),
                    'judul' => $validated['judul'],
                    'jenis' => $validated['jenis'],
                    'unit_kerja' => $validated['unit_kerja'],
                    'deskripsi' => $validated['deskripsi'],
                    'tanggal_berlaku' => $validated['tanggal_berlaku'],
                    'status' => 'Draft'
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Draft berhasil disimpan',
                'draft_id' => $draft->id,
                'updated_at' => $draft->updated_at
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan draft: ' . $e->getMessage()
            ], 422);
        }
    }
}
