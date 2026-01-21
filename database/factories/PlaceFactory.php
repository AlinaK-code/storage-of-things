<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Place;
use App\Models\Thing;
use App\Models\UseRecord;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
        'name' => fake()->word(),
        'description' => fake()->sentence(),
        'repair' => fake()->boolean(),
        'work' => fake()->boolean(),
    ];
    }
}
