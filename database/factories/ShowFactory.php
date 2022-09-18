<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Show>
 */
class ShowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->,
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
    }
}
