<?php

namespace App\Modules\Users\Services;

use App\Modules\Users\Models\UserJsonAttribute;
use App\Modules\Users\Models\UserJsonAttributeKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserJsonAttributeService
{
    /**
     * @var UserJsonAttributeKey
     */
    private UserJsonAttributeKey $userJsonAttributeKey;

    private function __construct(string $key)
    {
        /** @var UserJsonAttributeKey $model */
        $model = UserJsonAttributeKey::query()->findOrFail($key);
        $this->userJsonAttributeKey = $model;
    }

    public static function newInstance(string $key): UserJsonAttributeService
    {
        return new self($key);
    }

    /**
     * @param array $data
     * @return UserJsonAttributeService
     * @throws ValidationException
     */
    public function validate(array $data): static
    {
        $rules = $this->userJsonAttributeKey->validation_rules ?? [];

        if (!empty($rules)) {

            Validator::make(
                $data,
                $rules,
                $this->userJsonAttributeKey->validation_messages ?? [],
                $this->userJsonAttributeKey->validation_custom_attributes ?? []
            )->validate();
        }

        return $this;
    }

    /**
     * @param int $userId
     * @param array $value
     * @return Model
     */
    public function upsert(int $userId, array $value): Model
    {
        // system::portfolio::experiences
        return UserJsonAttribute::query()->updateOrCreate(
            ['user_id' => $userId, 'key' => $this->userJsonAttributeKey->key],
            ['value' => $value]
        );
    }

    public function getValue(int $userId): array
    {
        return UserJsonAttribute::getValueFromKey($userId, $this->userJsonAttributeKey->key);
    }

    /**
     * @return UserJsonAttributeKey
     */
    public function getJsonAttributeKey(): UserJsonAttributeKey {
        return $this->userJsonAttributeKey;
    }
}
