<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Place;
use App\Models\Thing;
use App\Models\UseRecord;

use Illuminate\Database\Eloquent\Factories\Factory;

class ThingFactory extends Factory
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
        'wrnt' => fake()->date(),
        'master' => User::factory(),
    ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Thing $thing) {
            Description::factory()->create([
                'thing_id' => $thing->id,
                'is_current' => true,
            ]);
        });
    }
}
