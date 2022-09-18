<?php

namespace Database\Factories;

use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'show_id' => Show::inRandomOrder()->first()->id,
            'season' => $this->faker->randomNumber(),
            'episode_number' => $this->faker->randomNumber(),
            'air_at' => $this->faker->dateTime(),
        ];
    }
}
