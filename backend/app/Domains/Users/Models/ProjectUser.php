<?php

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{

    protected $table = 'project_users';

    protected $fillable = [
        'user_id',
        'project_id',
    ];
}
