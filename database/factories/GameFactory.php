<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'genre' => $this->faker->randomElement(['Action', 'Adventure', 'RPG', 'Sports', 'FPS', 'Strategy', 'Puzzle']),
            'description' => $this->faker->paragraph(2), // Generate a random description
            'release_date' => $this->faker->date(), // Generate a random release date
        ];
    }
}
