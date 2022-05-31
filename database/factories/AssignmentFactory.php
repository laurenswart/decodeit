<?php

namespace Database\Factories;

use App\Models\Assignment;
use Carbon\Carbon;
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
       
        $created = $this->faker->dateTimeBetween(new DateTime('-2 months'), new DateTime('-1 months -1 days'));
       
        $created->setTime(rand(3,23), rand(0,59));
       
        $start = $this->faker->dateTimeBetween($created, new DateTime('+1 months'));
        $start->setTime(rand(3,23), rand(0,59));
        $updated =  $this->faker->dateTimeBetween($created, new DateTime('-1 months'));
        $updated->setTime(rand(3,23), rand(0,59));
        $endTime = $this->faker->dateTimeBetween($start, new DateTime('+3 months'));//
        $endTime->setTime(rand(3,23), rand(0,59));
        $isTest = $this->faker->boolean(30);
        return [
            'created_at' => $created->format('Y-m-d H:i:s'),
            'updated_at' => rand(0,10)<3 ? $updated->format('Y-m-d H:i:s') : null,
            'deleted_at' => null,
            'start_time' => $start->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
            'max_mark' => rand(1,10)*10,
            'course_weight' =>  $isTest ? rand(1,10)*10 : 0,
            'is_test' => $isTest
        ];
    }
}
