<?php

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $table = 'user_logins';

    protected $fillable = [
        'user_id',
        'type',
        'ip',
        'user_agent',
        'referer',
        'misc_json',
    ];

    const DB_TYPE_LOGIN = 'LOGIN';
    const DB_TYPE_LOGIN_ATTEMPT = 'LOGIN_ATTEMPT';
}
