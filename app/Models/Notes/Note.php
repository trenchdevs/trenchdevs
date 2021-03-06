<?php

namespace App\Models\Notes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';
    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'date'
    ];

}
