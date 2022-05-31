<?php

namespace Database\Factories;

use App\Models\Course;
use Carbon\Carbon;
use DateTime;
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
            'created_at'=>$this->faker->dateTimeBetween(new DateTime('-3 months'), new DateTime('-2 months'))->setTime(rand(3,23), rand(0,59))->format('Y-m-d H:i:s'),
            'updated_at'=>null,
        ];
    }
}
