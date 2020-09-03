<?php

namespace App\Models\Projects;

use App\Models\Users\ProjectUser;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'is_personal',
        'title',
        'url',
        'repository_url',
    ];

    public function projectUsers(){
        return $this->hasMany(ProjectUser::class);
    }
}
