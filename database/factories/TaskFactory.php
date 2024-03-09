<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => substr($this->faker->sentence(), 0, 10),
            'content' => substr($this->faker->sentence(), 0, 30),
            'begin' => $this->faker->date(),
            'status' => rand(0, 2),
            'published' => $this->faker->boolean(),
            'remarks' => substr($this->faker->text(), 0, 40),
            'user_id' => rand(1, User::count()),
        ];
    }
}