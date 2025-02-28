<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use App\Models\Conversation;

use App\Models\SubjectUser;
use Database\Seeders\PsermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Existing seeders
        $this->call([
            RoleSeeder::class,
            PsermissionSeeder::class,
        ]);

        // Create admin user
        $user = User::factory()->create([
            'name' => 'dynamite',
            'email' => 'dynamite@Gmail.com',
            'password' => bcrypt('123'),
        ]);
        $user->assignRole('admin');
        $user->syncPermissions("active");

        $user = User::factory()->create([
            'name' => 'madara',
            'email' => 'madara@Gmail.com',
            'password' => bcrypt('123'),
        ]);
        $user->assignRole('user');
        $user->syncPermissions("active");
        // Create regular users and subjects
        User::factory(1000)->create();
        Subject::factory(20)->create();

        // Create subject_user relationships
        // $users = User::all();
        // $subjects = Subject::all();

        // foreach ($users as $user) {
        //     // Assign 3-8 random subjects to each user
        //     $randomSubjects = $subjects->random(fake()->numberBetween(3, 8));

        //     foreach ($randomSubjects as $subject) {
        //         SubjectUser::create([
        //             'user_id' => $user->id,
        //             'subject_id' => $subject->id,
        //             'mark' => fake()->numberBetween(0, 100),
        //         ]);
        //     }
        // }


    }
}
