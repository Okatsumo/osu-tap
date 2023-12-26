<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $beatmaps = \App\Models\Beatmap::factory(120)->create();

        \App\Models\Beatmapset::factory(30)
            ->create()
            ->each(function ($beatmapset) use ($beatmaps) {
                $beatmapset->beatmaps()->attach(
                    $beatmaps->random(rand(1, 100))->pluck('id')->toArray()
                );
            });


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
