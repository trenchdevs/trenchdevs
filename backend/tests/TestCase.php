<?php

namespace Tests;

use App\Modules\Users\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function initialSeed(){
        $now = date('Y-m-d H:i:s');


        DB::table('application_types')->insert([
            'name' => 'ecommerce',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('accounts')->insert([
            'application_type_id' => 1,
            'owner_user_id' => null,
            'business_name' => 'Test Commerce',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $user = new User([
            'id' => 1,
            'email' => 'test@email.com',
            'password' => Hash::make('123456'),
            'account_id' => 1,
            'role' => 'business_owner',
        ]);

        $user->save();
    }
}
