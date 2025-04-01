<?php

namespace Database\Factories;

use App\Models\Sections;
use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sections>
 */
class SectionsFactory extends Factory
{
    protected $model = Sections::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'class_id' => Classes::factory(),
            'capacity' => $this->faker->numberBetween(20, 50),
            // 'status' => $this->faker->boolean(),
        ];
    }
}
