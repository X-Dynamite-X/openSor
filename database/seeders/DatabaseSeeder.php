<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'dynamite',
            'email' => 'dynamite@Gmail.com',
            'password' => bcrypt('123'),
            'is_admin' => true,
        ]);
        User::factory(1000)->create();
        Subject::factory(1000)->create();
    }
}
