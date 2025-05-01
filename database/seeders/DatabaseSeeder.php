<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'M7md Maher',
            'email' => 'm7mdmaher@gmail.com',
            'phone' => '01234567890',
            'password' => Hash::make('M7mdmaher11'),
        ]);
    }
}
