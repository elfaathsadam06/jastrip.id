<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'pesanan_id','method','bukti','amount','status','paid_at'
    ];

    public function pesanan() {
        return $this->belongsTo(Pesanan::class);
    }
}


