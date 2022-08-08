<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 * @property int $user_id
 * @property string $key
 * @property array $value
 */
class UserJsonAttribute extends Model
{
    protected $table = 'user_json_attributes';

    protected $fillable = [
        'user_id',
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'array'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @param int $id
     * @param string $key
     * @param array $default
     * @return array
     */
    public static function getValueFromKey(int $id, string $key, $default = []): array
    {
        return UserJsonAttribute::query()
                ->join('user_json_attribute_keys', 'user_json_attribute_keys.key', '=', 'user_json_attributes.key')
                ->where('user_json_attributes.user_id', '=', $id)
                ->where('user_json_attributes.key', '=', $key)
                ->first()
                ->value ?? $default;
    }

}
