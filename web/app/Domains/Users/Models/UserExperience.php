<?php

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserExperience extends Model
{

    use SoftDeletes;

    protected $table = 'user_experiences';

    protected $fillable = [
        'user_id',
        'title',
        'company',
        'description',
        'start_date',
        'end_date',
    ];
}
