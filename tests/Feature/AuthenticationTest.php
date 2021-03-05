<?php

namespace Tests\Feature;

use App\Account;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

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
            'email' => 'test@email.com',
            'password' => Hash::make('123456'),
            'account_id' => 1,
            'role' => 'business_owner',
        ]);

        $user->save();
    }

    /** @test */
    public function it_will_register_a_user()
    {
        $response = $this->post('api/auth/register', [
            'first_name' => 'Test',
            'last_name' => 'User1',
            'email' => 'test2@email.com',
            'password' => '123456',
            'role' => 'business_owner',
            'account_id' => 1,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in'
            ]
        ]);
    }

    /** @test */
    public function it_will_log_a_user_in()
    {
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertJsonStructure([
           'data' => [
               'access_token',
               'token_type',
               'expires_in'
           ]
        ]);

        return $response['data']['access_token'];
    }

    /** @test */
    public function it_will_not_log_an_invalid_user_in()
    {
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => 'notlegitpassword'
        ]);

        $response->assertJsonStructure([
            'error',
        ]);
    }

    /**
     * @test
     * @param string $accessToken
     * @depends it_will_log_a_user_in
     */
    public function it_will_get_user_details(string $accessToken)
    {
        $this->assertNotEmpty($accessToken);
        $response = $this->withHeader('Authorization', "Bearer $accessToken")
            ->json('post', 'api/auth/me', []);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->assertJson([
            'data' => [
                'email' => 'test@email.com'
            ],
        ]));

        $response->assertStatus(200);
    }

    /**
     * @test
     * @param string $accessToken
     * @depends it_will_log_a_user_in
     */
    public function aUserIsAbleToRefreshToken(string $accessToken)
    {
        $this->assertNotEmpty($accessToken);
        $response = $this->withHeader('Authorization', "Bearer $accessToken")
            ->json('post', 'api/auth/refresh', []);

        $response->assertStatus(200);

        $responseArr = $response->json();
        $this->assertNotEmpty($responseArr);
        $this->assertArrayHasKey('token', $responseArr['data']);
    }
}
