<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Penting untuk Login
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin'; // Sesuaikan dengan nama tabel di DB Anda
    protected $guarded = [];
    protected $hidden = ['password'];
}