<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{

    const CODES = [
        'some code 1',
        'some code 2',
        'some code 3',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => 'ran',
            
            'content' => self::CODES[array_rand(self::CODES)],
            'console' => null,
            'question' =>  rand(1,10)<5 ? $this->faker->realText(500) : null,
        ];
    }

    /**
     * Indicate the model's role
     *
     * @return static
     */
    public function assignment($assignment)
    {
        return $this->state(function ($attributes) use ($assignment) {
            $created = $this->faker->dateTimeBetween($assignment->start_time_carbon(), min(now(), $assignment->end_time_carbon() ));
            $feedback =  rand(1,10)<5 ? $this->faker->realText(500) : null;
            return [
                'created_at' => $created,
                'updated_at' => $created,
                'feedback' =>  $feedback,
                'feedback_at' => $feedback ? $this->faker->dateTimeBetween($created, min(now(), $assignment->end_time_carbon() )) : null,
            ];
        });
    }
}
