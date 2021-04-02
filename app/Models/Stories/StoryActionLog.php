<?php

namespace App\Models\Stories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryActionLog extends Model
{
    protected $table = 'story_action_logs';

    protected $fillable = [
        'story_id',
        'hash',
        'meta_json',
    ];
}
