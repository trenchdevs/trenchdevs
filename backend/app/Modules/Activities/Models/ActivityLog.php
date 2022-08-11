<?php

namespace App\Modules\Activities\Models;

use App\Support\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use SiteScoped;

    protected $table = 'activity_logs';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
      'site_id',
      'user_id',
      'type',
      'title',
      'contents',
      'image_url',
      'meta',
    ];


}
