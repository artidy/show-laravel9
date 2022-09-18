<?php

namespace Tests\Feature;

use App\Models\Show;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $show = [
        'id' => 1,
        'title' => 'Game of Thrones',
        'title_original' => 'Game of Thrones',
        'description' => 'Based on the bestselling book series A Song of Ice and Fire by George R.R. 
            Martin, this sprawling new HBO drama is set in a world where summers span decades and winters can 
            last a lifetime. From the scheming south and the savage eastern lands, to the frozen north and ancient 
            Wall that protects the realm from the mysterious darkness beyond, the powerful families of the Seven 
            Kingdoms are locked in a battle for the Iron Throne. This is a story of duplicity and treachery, 
            nobility and honor, conquest and triumph. In the Game of Thrones, you either win or you die.',
        'year' => 2011,
        'status' => 'ended',
        'imdb_id' => 'tt0944947',
    ];

    private array $episode = [
        'id' => 1,
        'title' => 'The Dragon and the Wolf',
        'season' => 7,
        'episode_number' => 7,
        'air_at' => '2017-08-28 01:00:00',
    ];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index(): void
    {
        $episodeId = $this->episode->id;
        $newEpisode = Show::factory()->create($this->show)->attach($this->episode);
        $response = $this->getJson("/api/episodes/$episodeId/comments");

        $response->assertStatus(200);
    }
}
