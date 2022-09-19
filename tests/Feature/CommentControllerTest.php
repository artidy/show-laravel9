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
        User::factory(1)->create();
        Show::factory(1)->create();
        Episode::factory(1)->create();
        Comment::factory(10)->create();
        $episode = Episode::all()->first();

        $response = $this->getJson("/api/episodes/$episode->id/comments");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
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

    public function test_add_comment(): void
    {
        User::factory(1)->create();
        Show::factory(1)->create();
        Episode::factory(1)->create();
        $episode = Episode::all()->first();
        $user = User::all()->first();

        $response = $this
            ->actingAs($user, 'web')
            ->postJson("/api/episodes/$episode->id/comments", [
                'text' => 'Test message',
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                $json->whereAllType($this->dataFields)
                    ->has('comments', 1, fn ($json) =>
                    $json->whereAllType($this->commentFields)
                        ->has('user', fn ($json) =>
                        $json->whereAllType($this->userFields)
                        )
                    )
                )
            );

        $comment = Comment::all()->first();

        $response = $this
            ->actingAs($user, 'web')
            ->postJson("/api/episodes/$episode->id/comments/$comment->id", [
                'text' => 'Test message',
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                $json->whereAllType($this->dataFields)
                    ->has('comments', 2, fn ($json) =>
                    $json->whereAllType($this->commentFields)
                        ->has('user', fn ($json) =>
                        $json->whereAllType($this->userFields)
                        )
                    )
                )
            );
    }

    public function test_delete_comment(): void
    {
        User::factory(1)->create();
        Show::factory(1)->create();
        Episode::factory(1)->create();
        Comment::factory(1)->create();
        $comment = Comment::all()->first();
        $user = User::all()->first();

        $response = $this
            ->actingAs($user, 'web')
            ->deleteJson("/api/comments/$comment->id");

        $response->assertStatus(200);
    }
}
