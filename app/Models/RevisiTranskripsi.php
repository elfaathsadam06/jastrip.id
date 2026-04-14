<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisiTranskripsi extends Model
{
    protected $table = 'revisi_transkripsi';

    protected $fillable = [
        'pesanan_id',        // ⬅️ WAJIB
        'transkripsi_id',
        'transkriptor_id',
        'hasil_revisi',
        'catatan',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function transkripsi()
    {
        return $this->belongsTo(Transkripsi::class);
    }

    public function transkriptor()
    {
        return $this->belongsTo(User::class, 'transkriptor_id');
    }
}
