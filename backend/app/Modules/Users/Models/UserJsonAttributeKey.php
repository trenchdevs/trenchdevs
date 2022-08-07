<?php

namespace App\Modules\Users\Models;

use App\Modules\Forms\Models\DynamicForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property  DynamicForm $form
 * @property  string $key
 * @property  string $description
 * @property  string $form_identifier
 * @property  array $sample_value
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
        'form_identifier',
        'sample_value'
    ];

    protected $casts = [
        'validation_rules' => 'array',
        'validation_messages' => 'array',
        'validation_custom_attributes' => 'array',
        'sample_value' => 'array',
        'dynamic_form_elements' => 'array',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(UserJsonAttribute::class, 'key', 'key');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(DynamicForm::class, 'form_identifier', 'form_identifier');
    }

    /**
     * @param int $userId
     * @param null $default
     * @return mixed
     */
    public function getValueForUser(int $userId, $default = null): mixed
    {
        return UserJsonAttribute::getValueFromKey($userId, $this->key) ?? $default;
    }

}
