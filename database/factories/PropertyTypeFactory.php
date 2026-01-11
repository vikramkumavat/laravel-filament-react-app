<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyType>
 */
class PropertyTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'House',
                'Apartment',
                'Office',
                'Villa',
                'Townhouse',
                'Cottage',
                'Studio',
                'Duplex'
            ]),
        ];
    }
}
