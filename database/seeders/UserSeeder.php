<?php

namespace Database\Seeders;

use App\Repositories\Users\UserRepository; // Ensure correct namespace
use App\Repositories\Users\UsersRepository;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private UsersRepository $users;

    /**
     * Inject UserRepository dependency
     */
    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->users->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
            ]);
        }
    }
}
