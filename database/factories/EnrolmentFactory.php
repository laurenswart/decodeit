<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrolment>
 */
class EnrolmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $mark = rand(0,10)<2 ;
        if($mark) {
            return [
                'final_mark' => $this->faker->numberBetween(10,100),
            ];
        } else {
            return [
                'final_mark' => NULL,
                'marked_at' => NULL,
                'updated_at' => NULL,
            ];
        }
    }
}
