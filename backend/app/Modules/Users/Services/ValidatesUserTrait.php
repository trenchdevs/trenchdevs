<?php

namespace App\Modules\Users\Services;

use App\Modules\Users\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

trait ValidatesUserTrait
{
    /**
     * @param bool $create
     * @param bool $rolesCheck
     * @return array
     */
    #[ArrayShape(['first_name' => "string[]", 'last_name' => "string[]", 'is_active' => "array", 'role' => "array", 'password' => "string[]", 'email' => "array"])]
    protected function validator(bool $create, bool $rolesCheck = true): array
    {
        /** @var User $user */
        $user = Auth::user();

        $defaultValidator = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'is_active' => ['required', Rule::in('1', '0')],
        ];

        if ($rolesCheck) {
            $defaultValidator['role'] = ['required', Rule::in($user->getAllowedRolesToManage())];
        }

        if ($create) {
            $defaultValidator['email'] = ['required', 'string', 'email', 'max:255', Rule::unique('users')->where(function (Builder $query) {
                $query->where('email', '=', request()->input('email'));
                $query->where('site_id', '=', site_id());
            })];
            $defaultValidator['password'] = ['required', 'string', 'min:8'];
        }

        return $defaultValidator;
    }
}
