<?php

namespace Database\Factories;

use Carbon\Carbon;
use DateTime;
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
        $timestamp = Carbon::createFromTimestamp($this->faker->dateTimeBetween(new DateTime('-6 months'), new DateTime('-5 months'))->getTimestamp())->setHour(rand(3,23));
        return [
            'firstname' => $this->faker->firstname(),
            'lastname' => $this->faker->lastname(),
            'email' => $this->faker->unique()->safeEmail(),
            'role_id' => 2,
            'email_verified_at' => $timestamp,
            'password' => bcrypt('epfcEPFC123!'),
            'created_at' => $timestamp->format('Y-m-d H:i:s'),
            'updated_at' => null,
            'deleted_at' => null,
            'remember_token' => null,
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
     * Indicate the model's role
     *
     * @return static
     */
    public function role($role='student')
    {
        return $this->state(function ($attributes) use ($role) {
            return [
                'role_id' => ($role=='teacher' ? 1 : 2),
            ];
        });
    }
}
