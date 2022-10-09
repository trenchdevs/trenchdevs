<?php

namespace App\Modules\Sites\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteConfigKey extends Model
{
    protected $table = 'site_config_keys';
    public $timestamps = false;

    protected $primaryKey = 'key_name';

    protected $fillable = [
        'key_name',
        'module',
        'description',
    ];

}
