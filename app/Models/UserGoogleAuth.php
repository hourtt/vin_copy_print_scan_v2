<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Use this if they need to log in

class UserGoogleAuth extends Authenticatable
{
    protected $table = 'user_google_auth';
    
    protected $fillable = [
        'google_id',
        'name',
        'email',
        'avatar',
        'google_token',
    ];
}