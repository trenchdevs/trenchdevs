<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property $id
 * @property $user_id
 * @property $title
 * @property $company
 * @property $description
 * @property $start_date
 * @property $end_date
 */
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
