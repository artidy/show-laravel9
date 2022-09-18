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
            'title' => $this->faker->sentence(),
            'title_original' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'year' => $this->faker->year(),
            'status' => $this->faker->randomElement(['ended', 'running']),
            'imdb_id' => $this->faker->regexify('tt[0-9]{7}'),
        ];
    }
}
