<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pesanan;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','role','status',
        'phone','address','email_verified_at',
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* =====================
     * RELATIONS
     * ===================== */

    // CUSTOMER → PESANAN
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    // ADMIN → PESANAN YANG DIA VERIFIKASI
    public function pesananDiverifikasi()
    {
        return $this->hasMany(Pesanan::class, 'verified_by_admin_id');
    }

    // TRANSKRIPTOR → PESANAN YANG DIA KERJAKAN
    public function pesananTranskriptor()
    {
        return $this->hasMany(Pesanan::class, 'assigned_transkriptor_id');
    }

    /* =====================
     * ROLE HELPERS
     * ===================== */
    public function isAdmin()        { return $this->role === 'admin'; }
    public function isCustomer()     { return $this->role === 'customer'; }
    public function isTranskriptor() { return $this->role === 'transkriptor'; }
    public function isOwner()        { return $this->role === 'owner'; }
}
