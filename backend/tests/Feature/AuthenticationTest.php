<?php

namespace Tests\Feature;


use App\Modules\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @group auth.sanctum
 * Class AuthenticationTest
 * @package Tests\Feature
 */
class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->initialSeed();
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
               'id',
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

        $response->assertJson([
            'status' => 'error',
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

        Sanctum::actingAs(User::query()->find(1));
        $response = $this->withHeader('Authorization', "Bearer $accessToken")
            ->post( 'api/auth/me', []);

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
        Sanctum::actingAs(User::query()->find(1));

        $response = $this->withHeader('Authorization', "Bearer $accessToken")
            ->post( 'api/auth/refresh', []);

        $response->assertStatus(200);
        $responseArr = $response->json();
        $this->assertNotEmpty($responseArr);
        $this->assertArrayHasKey('access_token', $responseArr['data']);
    }
}
