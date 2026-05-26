<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLog extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'reviewer_id',
        'reviewer_level',
        'action',
        'note',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    /** RELATIONS */

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
