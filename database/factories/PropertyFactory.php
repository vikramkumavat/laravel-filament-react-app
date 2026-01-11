<?php

namespace Database\Factories;

use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure a PropertyType exists, or create one
        $propertyType = PropertyType::inRandomOrder()->first() ?? PropertyType::factory()->create();

        return [
            'owner_name' => $this->faker->name,
            'bank_name' => $this->faker->company,
            'property_type_id' => $propertyType->id,
            'emd_price' => $this->faker->randomFloat(2, 10000, 50000),
            'price' => $this->faker->randomFloat(2, 100000, 1000000),
            'location' => $this->faker->address,
            'sq_ft' => $this->faker->numberBetween(800, 5000),
            // 'starting_price' => $this->faker->randomFloat(2, 90000, 950000),
            'image' => $this->faker->imageUrl(640, 480, 'house', true),
            'status' => $this->faker->randomElement(['pending', 'done']),
        ];
    }
}
