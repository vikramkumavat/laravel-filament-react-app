<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Vikram',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
            'is_admin' => (bool) 1,
        ]);

        $this->call([
            PropertyTypeSeeder::class,
            PropertySeeder::class,
            AuctionSeeder::class, // assuming you already created it
        ]);
    }
}
