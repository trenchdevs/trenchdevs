<?php

namespace Tests\Feature;

use App\Modules\Notes\Models\GroceryNote;
use App\Modules\Notes\Models\Note;
use App\Modules\Users\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiNotesTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->initialSeed();
    }

    /**
     * A basic feature test example.
     *
     * @group notes
     * @return void
     */
    public function testExample()
    {

        /** @var Authenticatable $user */
        $user = User::query()->find(1);

        Note::query()->create([
            'user_id' => $user->id,
            // 'type' => 'grocery',
            'title' => 'March 2, 2021',
            'date' => '2021-03-02',
            'type' => 'note',
            'contents' => json_encode([
                'cart' => [
                    [
                        'name' => 'Apple',
                        'quantity' => 3,
                    ],
                    [
                        'name' => 'Banana',
                        'quantity' => 2
                    ]
                ],
                'done' => [
                    [
                        'name' => 'Orange',
                        'quantity' => 6
                    ]
                ]
            ])
        ]);

        Sanctum::actingAs($user, ['*']);
        $response = $this->post('api/notes', ['type' => 'note']);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'current_page' => 1,
                'data' => [
                    [
                        'title' => 'March 2, 2021'
                    ]
                ]
            ]
        ]);
    }
}
