<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReaction extends Model
{
    use HasFactory;

    protected $table = 'product_reactions';
    protected $fillable = [
        'product_id',
        'reaction',
        'user_identifier',
        'meta_json',
    ];

    const WHITELISTED_REACTIONS = [
        'like',
        'dislike'
    ];
}
