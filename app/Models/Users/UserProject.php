<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{

    protected $table = 'user_experiences';

    protected $fillable = [
        'user_id',
        'is_personal',
        'title',
        'url',
        'repository_url',
    ];
}
