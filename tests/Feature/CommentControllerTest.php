<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Episode;
use App\Models\Show;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

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
    }
}
