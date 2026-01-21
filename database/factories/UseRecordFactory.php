<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Place;
use App\Models\Thing;
use App\Models\UseRecord;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UseRecord>
 */
class UseRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
        'thing_id' => Thing::factory(),
        'place_id' => Place::factory(),
        'user_id' => User::factory(),
        'amount' => fake()->numberBetween(1, 10),
    ];
    }
}
