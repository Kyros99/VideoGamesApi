<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Rating;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create 500 users
        User::factory(10)->create()->each(function ($user) {
            // Assign each user between 5 and 10 games
            $games = Game::factory(100)->create([
                'user_id' => $user->id,
            ]);

            // Each game gets a review and rating from its owner
            $games->each(function ($game) use ($user) {
                Review::factory()->create([
                    'game_id' => $game->id,
                    'user_id' => $user->id, // The owner reviews their own game
                ]);

                Rating::factory()->create([
                    'game_id' => $game->id,
                    'user_id' => $user->id, // The owner rates their own game
                ]);
            });
        });
    }
}
