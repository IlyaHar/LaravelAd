<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'description' => fake()->sentences(20, 10),
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtG7ujCdSdRXNLjRFMMSwwsWMQmt73fTMghg&s',
            'author_id' => User::factory()
        ];
    }
}
