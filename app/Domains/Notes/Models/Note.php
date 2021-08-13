<?php

namespace App\Domains\Notes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $casts = [
        'contents' => 'array',
    ];

    const DB_TYPE_NOTE = 'note';
    const DB_TYPE_NOTE_TEMPLATE = 'note_template';

    protected $table = 'notes';
    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'date'
    ];

    public static function getValidTypes (): array{
        return [
          self::DB_TYPE_NOTE,
          self::DB_TYPE_NOTE_TEMPLATE,
        ];
    }

    public static function isValidType(string $type): bool{
        return in_array($type, self::getValidTypes());
    }
}
