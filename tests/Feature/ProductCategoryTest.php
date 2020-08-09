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
            ])
            ->assertJson([
                'product_categories' => [
                    [
                        'id' => 1,
                        'parent_id' => NULL,
                        'account_id' => 1,
                        'name' => 'Shirts',
                        'is_featured' => 0,
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_will_return_specified_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/product_categories/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ])
            ->assertJson([
                'product_category' => [
                    'id' => 1,
                    'parent_id' => NULL,
                    'account_id' => 1,
                    'name' => 'Shirts',
                    'is_featured' => 0,
                ]
            ]);
    }

    /** @test */
    public function it_will_return_parent_product_categories()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('GET', '/api/product_categories/parent_categories');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'parent_categories',
            ])
            ->assertJson([
                'parent_categories' => [
                    [
                        'id' => 1,
                        'parent_id' => NULL,
                        'account_id' => 1,
                        'name' => 'Shirts',
                        'is_featured' => 0
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_will_add_a_parent_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/upsert', [
                'name' => 'Pants',
                'is_featured' => 0,
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ])
            ->assertJson([
                'product_category' => [
                    'id' => 2,
                    'account_id' => 1,
                    'parent_id' => NULL,
                    'name' => 'Pants',
                    'is_featured' => 0,
                ],
            ]);
    }

    /** @test */
    public function it_will_add_a_featured_parent_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/upsert', [
                'name' => 'Pants',
                'is_featured' => 1,
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ])
            ->assertJson([
                'product_category' => [
                    'id' => 2,
                    'account_id' => 1,
                    'parent_id' => NULL,
                    'name' => 'Pants',
                    'is_featured' => 1,
                ],
            ]);
    }

    /** @test */
    public function it_will_add_a_child_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/upsert', [
                'parent_id' => 1,
                'name' => 'Polo Shirt',
                'is_featured' => 0,
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ])
            ->assertJson([
                'product_category' => [
                    'id' => 2,
                    'account_id' => 1,
                    'parent_id' => 1,
                    'name' => 'Polo Shirt',
                    'is_featured' => 0,
                ],
            ]);
    }

    /** @test */
    public function it_will_add_a_featured_child_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/upsert', [
                'parent_id' => 1,
                'name' => 'Polo Shirt',
                'is_featured' => 1,
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ])
            ->assertJson([
                'product_category' => [
                    'id' => 2,
                    'account_id' => 1,
                    'parent_id' => 1,
                    'name' => 'Polo Shirt',
                    'is_featured' => 1,
                ],
            ]);
    }

    /** @test */
    public function it_will_update_existing_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/upsert', [
                'id' => 1,
                'name' => 'Shirtzzz',
                'is_featured' => 1,
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ])
            ->assertJson([
                'product_category' => [
                    'id' => 1,
                    'name' => 'Shirtzzz',
                    'is_featured' => 1,
                ]
            ]);
    }

    /** @test */
    public function it_will_toggle_product_category_is_featured_flag()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/toggle_is_featured/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'product_category',
            ])
            ->assertJson([
                'product_category' => [
                    'id' => 1,
                    'name' => 'Shirts',
                    'is_featured' => 1,
                ]
            ]);
    }

    /** @test */
    public function it_will_delete_a_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/delete/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([]);
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

    /** @test */
    public function it_will_not_add_product_category_with_empty_json_data()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/upsert', []);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_add_child_product_category_with_invalid_parent_id()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '2',])
            ->json('POST', '/api/product_categories/upsert', [
                'parent_id' => 20,
                'name' => 'Test Category',
                'is_featured' => 0
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_toggle_non_existent_product_category_is_featured_flag()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '2',])
            ->json('POST', '/api/product_categories/upsert', [
                'parent_id' => 20,
                'name' => 'Test Category',
                'is_featured' => 0
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_not_delete_non_existent_product_category()
    {
        $response = $this
            ->withHeaders(['x-account-id' => '1',])
            ->json('POST', '/api/product_categories/delete/2');

        $response->assertStatus(404);
    }

}
