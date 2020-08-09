<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductTest extends TestCase
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
            'name' => 'Test Product Ctaegory',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('products')->insert([
            'account_id' => 1,
            'product_category_id' => 1,
            'name' => 'Test Product',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /** @test */
    public function it_will_return_all_products()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/products/');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'products',
            ])
            ->assertJson([
                'products' => [
                    [
                        'id' => 1,
                        'account_id' => 1,
                        'product_category_id' => 1,
                        'name' => 'Test Product',
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_will_not_return_all_products()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '2',])
            ->json('GET', '/api/products/');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_return_specified_product()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/products/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product',
            ])
            ->assertJson([
                'product' => [
                    'id' => 1,
                    'account_id' => 1,
                    'product_category_id' => 1,
                    'name' => 'Test Product',
                ]
            ]);
    }

    /** @test */
    public function it_will_not_return_non_existent_product()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/products/2');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_delete_specified_product()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/delete/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }

    /** @test */
    public function it_will_not_delete_non_existent_product()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/delete/2');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_add_a_product()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/upsert', [
                'product_category_id' => 1,
                'name' => 'Test Product',
                'description' => 'test',
                'stock' => 10,
                'product_cost' => 500,
                'is_on_sale' => FALSE,
                'shipping_cost' => 10,
                'handling_cost' => 20,
                'sale_product_cost' => 0,
                'final_cost' => 530,
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product'
            ])
            ->assertJson([
                'product' => [
                    'account_id' => 1,
                    'product_category_id' => 1,
                    'name' => 'Test Product',
                    'description' => 'test',
                    'stock' => 10,
                    'product_cost' => 500,
                    'is_on_sale' => FALSE,
                    'shipping_cost' => 10,
                    'handling_cost' => 20,
                    'sale_product_cost' => 0,
                    'final_cost' => 530,
                ]
            ]);
    }

    /** @test */
    public function it_will_not_add_a_product_with_invalid_product_category_id()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/upsert', [
                'product_category_id' => 'test'
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_add_a_product_with_invalid_name()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/upsert', [
                'name' => 10
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_add_a_product_with_invalid_description()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/upsert', [
                'description' => 10
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_add_a_product_with_invalid_stock()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/upsert', [
                'stock' => 'test'
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_add_a_product_with_invalid_product_cost()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/upsert', [
                'product_cost' => 'test'
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_add_a_product_with_non_existent_product_category_id()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/products/upsert', [
                'product_category_id' => 10,
                'name' => 'Test Product',
                'description' => 'test',
                'stock' => 10,
                'product_cost' => 500,
            ]);

        $response->assertStatus(404);
    }
}
