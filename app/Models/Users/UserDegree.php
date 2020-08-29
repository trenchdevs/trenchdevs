<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDegree extends Model
{
    use SoftDeletes;

    protected $table = 'user_degrees';

    protected $fillable = [
        'user_id',
        'degree',
        'educational_institution',
        'description',
        'start_date',
        'end_date',
    ];
}
