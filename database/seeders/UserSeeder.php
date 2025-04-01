<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash; // Add this line

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Hash the password correctly
        ]);

        Contact::factory()->create([
            'user_id' => $admin->id,
            'email' => 'rakhi@gmail.com',
            'phone' => '123456789',
            'address' => '123 Main Street',
        ]);

        // // Generate 10 random users with contacts
        // User::factory()
        //     ->has(Contact::factory()->count(1)) // Each user will have 1 contact
        //     ->count(10)
        //     ->create();
    }
}
