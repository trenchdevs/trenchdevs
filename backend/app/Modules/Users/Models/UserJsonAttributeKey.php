<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property  string $key
 * @property  string $description
 * @property  array $validation_rules
 * @property  array $validation_messages
 * @property  array $validation_custom_attributes
 * @property  array $sample_value
 * @property  array $dynamic_form_elements
 */
class UserJsonAttributeKey extends Model
{
    protected $table = 'user_json_attribute_keys';
    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'key',
        'description',
        'validation_rules',
        'validation_messages',
        'validation_custom_attributes',
        'dynamic_form_elements',
        'sample_value'
    ];

    protected $casts = [
        'validation_rules' => 'array',
        'validation_messages' => 'array',
        'validation_custom_attributes' => 'array',
        'sample_value' => 'array',
        'dynamic_form_elements' => 'array',
    ];

}
