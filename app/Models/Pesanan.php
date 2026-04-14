<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'order_number',
        'file_audio',
        'durasi',
        'total_biaya',

        // FLAG
        'need_transkriptor_verification',

        // STATUS
        'status',

        // ADMIN
        'verified_by_admin_id',
        'admin_action',
        'verified_at',

        // TRANSKRIPTOR
        'assigned_transkriptor_id',
        'status_transkriptor',
    ];

    /* =====================
     * RELATIONSHIP
     * ===================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminVerifier()
    {
        return $this->belongsTo(User::class, 'verified_by_admin_id');
    }

    public function transkriptor()
    {
        return $this->belongsTo(User::class, 'assigned_transkriptor_id');
    }

    public function transkripsi()
    {
        return $this->hasOne(Transkripsi::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
