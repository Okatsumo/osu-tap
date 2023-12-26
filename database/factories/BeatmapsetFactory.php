<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beatmapset>
 */
class BeatmapsetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'artist' => fake()->name() . ' ' . fake()->lastName(),
            'artist_unicode' => fake()->name() . ' ' . fake()->lastName(),
            'cover' => fake()->text(),
            'creator' => fake()->userName(),
            'nsfw' => fake()->boolean(),
            'play_count' => fake()->randomNumber(),
            'preview_url' => fake()->text(),
            'source' => fake()->text(),
            'spotlight' => fake()->boolean(),
            'status'   => fake()->randomElement(['ranked', 'qualified', 'disqualified', 'never_qualified']),
            'title' => fake()->name(),
            'title_unicode' => fake()->name(),
            'user_id' => fake()->randomNumber(),
            'video' => fake()->boolean(),
            'bpm' => fake()->randomFloat(2, 1, 1500),
            'ranked' => fake()->randomElement([1, 0]),
            'ranked_date' => fake()->dateTime(),
            'storyboard' => fake()->boolean(),
            'submitted_date' => fake()->dateTime(),
            'tags' => fake()->text(),
        ];
    }
}
