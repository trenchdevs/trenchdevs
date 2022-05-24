<?php

namespace App\Domains\Sites\Models;

use App\Support\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;

class SiteJson extends Model
{
    use SiteScoped;

    const KEY_SAMLIDP = 'samlidp';
    protected $table = 'site_jsons';

    protected $fillable = [
        'site_id',
        'key',
        'value',
    ];
}
