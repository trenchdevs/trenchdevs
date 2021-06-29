<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

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
