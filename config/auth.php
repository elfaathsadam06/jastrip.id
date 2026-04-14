<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Guard default tetap menggunakan "web" karena semua role login dari form
    | yang sama (Laravel Breeze / Fortify). Tidak perlu guard terpisah
    | kecuali kamu ingin halaman login berbeda untuk setiap role.
    |
    */
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Guard utama "web" digunakan oleh semua role.
    | Jika di masa depan kamu ingin login terpisah, kamu sudah siap —
    | cukup aktifkan salah satu guard khusus di bawah.
    |
    */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // OPSIONAL (jika nanti kamu mau login terpisah)
        'admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'customer' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'transkriptor' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'owner' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Semua guard di atas menggunakan provider "users".
    | Provider ini mengambil data dari model `App\Models\User`
    | (tabel `users`).
    |
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk fitur lupa password (opsional).
    |
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Waktu dalam detik sebelum password user harus dikonfirmasi ulang
    | (default: 3 jam = 10800 detik)
    |
    */
    'password_timeout' => 10800,

];
