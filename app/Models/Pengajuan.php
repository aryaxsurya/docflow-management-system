<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'user_id',
        'judul',
        'jenis',
        'unit_kerja',
        'deskripsi',
        'tanggal_berlaku',
        'lampiran',
        'status',
        'current_reviewer_level',

    ];

    /**
     * Pengajuan DIMILIKI oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'tanggal_berlaku' => 'datetime',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];

    public function reviewLogs()
    {
       return $this->hasMany(ReviewLog::class);
    }


}
