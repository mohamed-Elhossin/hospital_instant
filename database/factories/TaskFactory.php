<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>  $this->faker->numberBetween(1,3),
            'task_name' =>$this->faker->sentence(),
            'description'  =>$this->faker->sentence(),
            'note' =>$this->faker->sentence(),
            'image' => 'image.png',
            'status' => 'pending',
        ];
        
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
