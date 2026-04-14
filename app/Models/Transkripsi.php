<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transkripsi extends Model
{
    protected $table = 'transkripsi';

    protected $fillable = [
        'pesanan_id',
        'hasil',
        'status',
        'error_message'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function revisiTranskripsi()
    {
        return $this->hasMany(RevisiTranskripsi::class);
    }

    public function revisiTerakhir()
    {
        return $this->hasOne(RevisiTranskripsi::class)
            ->latestOfMany();
    }

}
