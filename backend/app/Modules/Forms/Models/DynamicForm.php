<?php

namespace App\Modules\Forms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property  $form_identifier
 * @property  $description
 * @property  $validation_rules
 * @property  $validation_messages
 * @property  $validation_custom_attributes
 * @property  $dynamic_form_elements
 */
class DynamicForm extends Model
{

    protected $table = 'dynamic_forms';
    protected $primaryKey = 'form_identifier';
    public $incrementing = false;

    protected $fillable = [
        'form_identifier',
        'description',
        'validation_rules',
        'validation_messages',
        'validation_custom_attributes',
        'dynamic_form_elements',
    ];
    protected $casts = [
        'validation_rules' => 'array',
        'validation_messages' => 'array',
        'validation_custom_attributes' => 'array',
        'sample_value' => 'array',
        'dynamic_form_elements' => 'array',
    ];


}
