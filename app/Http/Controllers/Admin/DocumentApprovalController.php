<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;

class DocumentApprovalController extends Controller
{
    public function draft()
    {
        $documents = $this->documentsByStatuses(['draft']);

        return view('admin.documents.draft', [
            'documents' => $documents,
            'title' => 'Draft Documents',
            'description' => 'Dokumen yang masih tersimpan sebagai draft dan belum masuk proses review.',
            'statusBadge' => 'DRAFT',
        ]);
    }

    public function review()
    {
        $documents = $this->documentsByStatuses(['review1', 'review2', 'review3']);

        return view('admin.documents.review', [
            'documents' => $documents,
            'title' => 'Under Review',
            'description' => 'Dokumen yang sedang diproses reviewer pada salah satu level review.',
            'statusBadge' => 'REVIEW',
        ]);
    }

    public function approval()
    {
        $documents = $this->documentsByStatuses(['approved']);

        return view('admin.documents.approval', [
            'documents' => $documents,
            'title' => 'Waiting Approval',
            'description' => 'Dokumen yang sudah selesai direview dan sedang menunggu keputusan admin.',
            'statusBadge' => 'APPROVAL',
        ]);
    }

    public function signing()
    {
        $documents = $this->documentsByStatuses(['signing']);

        return view('admin.documents.signing', [
            'documents' => $documents,
            'title' => 'Signing Process',
            'description' => 'Dokumen yang sudah diproses admin dan sedang berada di tahap penandatanganan.',
            'statusBadge' => 'SIGNING',
        ]);
    }

    public function archive()
    {
        $documents = $this->documentsByStatuses(['signed', 'archived']);

        return view('admin.documents.archive', [
            'documents' => $documents,
            'title' => 'Archived Documents',
            'description' => 'Dokumen yang sudah selesai dan tersimpan sebagai arsip.',
            'statusBadge' => 'ARCHIVE',
        ]);
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user', 'reviewLogs.reviewer'])->findOrFail($id);

        return view('admin.documents.show', compact('pengajuan'));
    }

    public function approve($id)
    {
        Pengajuan::where('id', $id)->update([
            'status' => 'signing',
        ]);

        return redirect()->route('admin.documents.approval')
            ->with('success', 'Dokumen dipindahkan ke proses penandatanganan.');
    }

    public function reject($id)
    {
        Pengajuan::where('id', $id)->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Dokumen ditolak oleh admin.');
    }

    private function documentsByStatuses(array $statuses)
    {
        return Pengajuan::with(['user', 'reviewLogs'])
            ->whereIn('status', $statuses)
            ->orderByDesc('updated_at')
            ->paginate(15)
            ->through(function ($item) {
                $item->status_label = strtoupper((string) $item->status);
                return $item;
            });
    }
}
