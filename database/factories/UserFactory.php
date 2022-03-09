<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstname(),
            'lastname' => $this->faker->lastname(),
            'email' => $this->faker->unique()->safeEmail(),
            'role_ref' => 2,
            'email_verified_at' => now(),
            'password' => '$2y$10$FacC.79UhaeugQhEEQRDquwRe97jsgBFk2/C7I.EEuZKFFs7NodfS', // password
            'created_at' => $this->faker->dateTimeBetween('15-10-2021 14:35:26', now()),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function role($role='student')
    {
        return $this->state(function ($attributes) use ($role) {
            return [
                'role_ref' => ($role=='teacher' ? 1 : 2),
            ];
        });
    }
}
