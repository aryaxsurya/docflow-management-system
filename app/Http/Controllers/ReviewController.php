<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    public function show(Document $document)
    {
        // Load document dengan user yang membuat
        $document->load('creator');

        return view('review.show', [
            'document' => $document
        ]);
    }
}
