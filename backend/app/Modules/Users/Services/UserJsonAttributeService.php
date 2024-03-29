<?php

namespace App\Modules\Users\Services;

use App\Modules\Users\Events\UserPortfolioDetailsUpdated;
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
        $rules = $this->userJsonAttributeKey->form->validation_rules ?? [];

        if (!empty($rules)) {

            Validator::make(
                $data,
                $rules,
                $this->userJsonAttributeKey->form->validation_messages ?? [],
                $this->userJsonAttributeKey->form->validation_custom_attributes ?? []
            )->validate();
        }

        return $this;
    }

    /**
     * @param int $userId
     * @param array $value
     * @return UserJsonAttribute
     */
    public function upsert(int $userId, array $value): UserJsonAttribute
    {
        /** @var UserJsonAttribute $jsonAttribute */
        $jsonAttribute = UserJsonAttribute::query()->updateOrCreate(
            ['user_id' => $userId, 'key' => $this->userJsonAttributeKey->key], // system::portfolio::experiences
            ['value' => $value]
        );

        if ($jsonAttribute->key === 'system::portfolio::details') {
            event(new UserPortfolioDetailsUpdated($jsonAttribute));
        }

        return $jsonAttribute;
    }

    public function getValue(int $userId, $default = []): array
    {
        return UserJsonAttribute::getValueFromKey($userId, $this->userJsonAttributeKey->key, $default);
    }

    public function getDynamicFormElements(): array
    {
        return $this->userJsonAttributeKey->form->dynamic_form_elements ?? [];
    }

    /**
     * @return UserJsonAttributeKey
     */
    public function getJsonAttributeKey(): UserJsonAttributeKey
    {
        return $this->userJsonAttributeKey;
    }
}
