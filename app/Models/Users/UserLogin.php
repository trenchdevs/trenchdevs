<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLogin extends Model
{

    use SoftDeletes;

    protected $table = 'user_experiences';

    protected $fillable = [
        'user_id',
        'type',
        'ip',
        'user_agent',
        'referer',
        'misc_json',
    ];
}
