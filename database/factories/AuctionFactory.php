<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(), // creates a related property
            'description' => $this->faker->sentence,
            'location' => $this->faker->address,
            'start_time' => $this->faker->dateTimeBetween('now', '+10 days'),
        ];
    }
}
