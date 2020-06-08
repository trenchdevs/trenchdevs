<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
