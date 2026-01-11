<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $propertyTypes = PropertyType::all()->count() >= 4
            ? PropertyType::all()->random(4)
            : PropertyType::all();

        if ($propertyTypes->isEmpty()) {
            $this->command->warn('No property types found. Please run PropertyTypeSeeder first.');
            return;
        }

        foreach ($propertyTypes as $type) {
            Property::factory()->create([
                'property_type_id' => $type->id,
            ]);
        }
    }
}
