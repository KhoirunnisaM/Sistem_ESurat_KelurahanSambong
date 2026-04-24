<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Supaya bisa login

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $guarded = [];
}