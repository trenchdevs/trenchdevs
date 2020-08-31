<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCertification extends Model
{
    Use SoftDeletes;

    protected $table = 'user_certifications';

    protected $fillable = [
        'user_id',
        'title',
        'issuer',
        'certification_url',
        'expiration_date',
    ];
}
