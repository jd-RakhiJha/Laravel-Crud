<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Create 2 contacts for each user
        $users->each(function ($user) {
            Contact::factory()->count(2)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
