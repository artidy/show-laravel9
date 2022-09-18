<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Episode;
use App\Models\Show;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $dataFields = [
        'count' => 'integer',
        'comments' => 'array',
    ];

    private array $commentFields = [
        'id' => 'integer',
        'user' => 'array',
        'comment' => 'string',
        'parent_id' => 'integer|null',
        'created_at' => 'string',
    ];

    private array $userFields = [
        'name' => 'string',
        'avatar' => 'string|null',
    ];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index(): void
    {
        User::factory(10)->create();
        Show::factory(1)->create();
        Episode::factory(1)->create();
        Comment::factory(10)->create();
        $episode = Episode::all()->first();

        $response = $this->getJson("/api/episodes/$episode->id/comments");

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', fn ($json) =>
                $json->whereAllType($this->dataFields)
                ->has('comments', 10, fn ($json) =>
                    $json->whereAllType($this->commentFields)
                    ->has('user', fn ($json) =>
                        $json->whereAllType($this->userFields)
                    )
                )
            )
        );
    }
}
