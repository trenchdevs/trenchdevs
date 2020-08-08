<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
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

        DB::table('product_categories')->insert([
            'account_id' => 1,
            'name' => 'Shirts',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /** @test */
    public function it_will_return_all_product_categories()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/product_categories/');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_categories',
            ]);
    }

    /** @test */
    public function it_will_return_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/product_categories/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ]);
    }

    /** @test */
    public function it_will_not_return_all_product_categories()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '2',])
            ->json('GET', '/api/product_categories/');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_return_non_existent_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/product_categories/2');

        $response
            ->assertStatus(404);
    }

}
