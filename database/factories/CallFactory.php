<?php

namespace Database\Factories;

use App\Models\Call;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class CallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Call::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'doctor_id'=>  $this->faker->numberBetween(1,3),
            'nurse_id'=>  $this->faker->numberBetween(4,6),
            'analysis_id'=>  $this->faker->numberBetween(6,8),
            'patient_name' =>$this->faker->name(),
            'age' =>  $this->faker->numberBetween(35,70),
            'phone' => '0020113'.$this->faker->numerify('#####'),
            'description' =>  $this->faker->sentence,
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
