<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // 1. Kasih tau Laravel kalau primary key-nya bukan 'id', tapi 'id_user'
    protected $primaryKey = 'id_user';

    // 2. Kasih tau Laravel kalau tabel ini TIDAK punya kolom 'updated_at'
    const UPDATED_AT = null;

    // 3. Sesuaikan nama kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_lengkap', // <-- Sesuaikan dengan gambar
        'username',
        'role',
        'password',
    ];

    /**
     * Attributes yang disembunyikan.
     */
    protected $hidden = [
        'password',
    ];
}
