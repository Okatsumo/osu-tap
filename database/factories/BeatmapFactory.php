<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beatmap>
 */
class BeatmapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'difficulty_rating' => fake()->randomFloat(1, 1, 5),
            'mode'              => fake()->randomElement(['fruits', 'mania', 'osu', 'taiko']),
            'status'            => fake()->randomElement(['ranked', 'qualified', 'disqualified', 'never_qualified']),
            'total_length'      => fake()->randomNumber(2),
            'user_id'           => fake()->randomNumber(3),
            'version'           => fake()->randomNumber(3),
            'accuracy'          => fake()->randomNumber(3),
            'ar'                => fake()->randomNumber(3),
            'bpm'               => fake()->randomNumber(3),
            'convert'           => fake()->boolean(),
            'count_circles'     => fake()->randomNumber(),
            'count_sliders'     => fake()->randomNumber(),
            'count_spinners'    => fake()->randomNumber(),
            'cs'                => fake()->randomNumber(),
            'deleted_at'        => null,
            'drain'             => fake()->randomNumber(),
            'hit_length'        => fake()->randomNumber(),
            'is_scoreable'      => fake()->boolean(),
            'mode_int'          => fake()->randomNumber(),
            'passcount'         => fake()->randomNumber(),
            'playcount'         => fake()->randomNumber(),
            'ranked'            => fake()->randomNumber(),
            'url'               => fake()->text(),
            'checksum'          => fake()->text(),
            'max_combo'         => fake()->randomNumber(),
        ];
    }
}
