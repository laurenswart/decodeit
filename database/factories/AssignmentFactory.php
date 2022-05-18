<?php

namespace Database\Factories;

use App\Models\Assignment;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $created = $this->faker->dateTimeBetween(new DateTime('-2 months'), new DateTime('-1 months'));
        $start = $this->faker->dateTimeBetween($created, new DateTime('+3 months'));
        $isTest = $this->faker->boolean(30);
        return [
            'created_at' => $created,
            'updated_at' => rand(0,10)<3 ? $this->faker->dateTimeBetween($created, new DateTime('-1 months')) : null,
            'deleted_at' => null,
            'start_time' => $start,
            'end_time' => $this->faker->dateTimeBetween($start, new DateTime('+3 months')),
            'max_mark' => rand(1,10)*10,
            'course_weight' =>  $isTest ? rand(1,10)*10 : 0,
            'is_test' => $isTest
        ];
    }
}
