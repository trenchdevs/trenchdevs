<?php

namespace App\Modules\Sites\Models;

use App\Modules\Sites\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;

class SiteJson extends Model
{
    use SiteScoped;

    const KEY_SAML_IDP = 'samlidp';

    protected $table = 'site_jsons';

    protected $fillable = [
        'site_id',
        'key',
        'value',
    ];
}
