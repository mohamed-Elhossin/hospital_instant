<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'gender' =>$this->faker->randomElement(['male','female']),
            'birthday' => now(),
            'specialist' => $this->faker->randomElement(['eyes','heart']),
            'status' => $this->faker->randomElement(['single','married']),
            'mobile' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'type' => $this->faker->randomElement(['hr','nurse','doctor','receptionist','analysis','manger']),
            'password' => Hash::make('12345678'), // password
            'avatar' => 'avatar.png', // password
            'device_token' => Str::random(10),
            'remember_token' => Str::random(10),
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
