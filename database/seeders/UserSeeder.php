<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        // ]);

        // // Create a contact for the admin user
        // Contact::factory()->create([
        //     'user_id' => $admin->id,
        //     'email' => 'rakhi@gmail.com',
        //     'phone' => '123456789',
        //     'address' => '123 Main Street',
        // ]);

        // Generate 10 random users with contacts
        User::factory()
            ->has(Contact::factory())
            ->count(10)
            ->create();
    }
}
