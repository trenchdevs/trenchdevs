<?php

namespace App\Domains\Sites\Models\Sites;

use App\Domains\Sites\Models\ApplicationType;
use App\Http\Controllers\Auth\RegisterController;
use App\Domains\Users\Models\User;
use Illuminate\Validation\Rule;

abstract class AbstractSite
{
    protected $defaultRole = User::ROLE_CUSTOMER;

    public abstract function domains(): array;

    public function getDefaultRole(): string{
        return $this->defaultRole;
    }

    public function registrationValidationRules () :array {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => RegisterController::PASSWORD_VALIDATION_RULE,
            'password_confirmation' => 'required|string|min:8',
            'role' => [
                'required',
                Rule::in([User::ROLE_BUSINESS_OWNER, User::ROLE_CUSTOMER]),
            ]
        ];
    }

    public abstract function getAppType(): ApplicationType;
}
