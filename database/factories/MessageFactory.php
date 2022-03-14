<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(){
        return [
            'content'=>$this->faker->realText(500),
            'created_at'=>$this->faker->dateTimeBetween($startDate = '-3 months', $endDate = '-2 months'),
            'updated_at'=>null,
        ];
    }
}
