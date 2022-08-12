<?php

namespace Database\Factories\Modules\Users\Models;

use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

class UserFactory extends Factory
{

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'password' => Hash::make('password'),
            'is_active' => true,
            'site_id' => 1,
            'avatar_url' => fake()->imageUrl(),
            'role' => User::ROLE_CUSTOMER,
        ];
    }
}
