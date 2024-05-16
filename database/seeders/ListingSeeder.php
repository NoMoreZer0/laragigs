<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
        ]);

        Listing::factory(3)->create([
            'user_id' => $user->id,
        ]);
    }
}
