<?php

namespace Tests\Utilities;

use App\Modules\Sites\Models\Site;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataCreator
{
    private Site $site;

    public function __construct(Site $site)
    {
        $this->site = $site;

        if (!app()->runningUnitTests()) {
            echoln_console("Forbidden. [DS_001]");
            die;
        }
    }

    /**
     * @param array $override
     * @return User
     */
    public function createUser(array $override = []): User
    {
        /** @var User $user */
        $user = User::query()->create(array_merge([
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email'  => fake()->email,
            'password' => fake()->randomNumber(32),
            'is_active' => true,
            'site_id' => $this->site->id,
            'avatar_url' => fake()->imageUrl(),
            'role' => User::ROLE_CUSTOMER,
        ], $override));
        return $user;
    }

}
