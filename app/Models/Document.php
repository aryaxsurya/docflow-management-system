<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'unit', 'description', 'effective_date',
        'status', 'attachment_path', 'creator_id',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'creator_id');
    }

    // helper
    public function isDraft()
    {
        return $this->status === 'draft';
    }
}
