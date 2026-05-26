<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\User;
use App\Notifications\DocumentSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // show form
    public function create()
    {
        return view('documents.create');
    }

    // store initial draft or full submit
    public function store(StoreDocumentRequest $request)
    {
        $user = Auth::user(); // asumsi user logged in
        $data = $request->only(['title','type','unit','description','effective_date']);

        // handle attachment if ada
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'public');
            $data['attachment_path'] = $path;
        }

        $data['creator_id'] = $user->id;
        // default status = draft
        $document = Document::create($data);

        return response()->json([
            'success' => true,
            'document' => $document,
        ]);
    }

    // autosave draft (AJAX) - bisa create or update
    public function autosave(Request $request)
    {
        $user = Auth::user();
        $payload = $request->only(['title','type','unit','description','effective_date','document_id']);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $payload['attachment_path'] = $path;
        }

        if (!empty($payload['document_id'])) {
            $doc = Document::where('id', $payload['document_id'])->where('creator_id', $user->id)->first();
            if ($doc) {
                $doc->update(array_filter($payload));
            } else {
                return response()->json(['success'=>false,'message'=>'Document not found'], 404);
            }
        } else {
            $payload['creator_id'] = $user->id;
            $payload['status'] = 'draft';
            $doc = Document::create($payload);
        }

        return response()->json(['success'=>true,'document_id'=>$doc->id,'updated_at'=>$doc->updated_at]);
    }

    // submit untuk review1
    public function submit(Request $request, $id)
    {
        $user = Auth::user();
        $doc = Document::where('id', $id)->where('creator_id', $user->id)->firstOrFail();

        $doc->status = 'review1';
        $doc->save();

        // temukan reviewer(s) — disini kita notifikasi semua users dengan role 'reviewer'
        $reviewers = User::where('role', 'reviewer')->get();
        Notification::send($reviewers, new DocumentSubmitted($doc));

        return response()->json(['success'=>true,'message'=>'Document submitted to Review1']);
    }


}
