<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserJsonAttribute extends Model {

    protected $table = 'user_json_attributes';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'array'
    ];



    /**
     * @param int $id
     * @param string $key
     * @return array
     */
    public static function getValueFromKey(int $id, string $key): array {
        return UserJsonAttribute::query()
            ->join('user_json_attribute_keys', 'user_json_attribute_keys.key', '=', 'user_json_attributes.key')
            ->where('user_json_attributes.user_id', '=', $id)
            ->where('user_json_attributes.key', '=', $key)
            ->first()
            ->value ?? [];
    }

}
