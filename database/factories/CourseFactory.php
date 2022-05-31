<?php

namespace Database\Factories;

use App\Models\Course;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $created = $this->faker->dateTimeBetween(new DateTime('-5 months'), new DateTime('-4 months -1 days'));
        $created->setTime(rand(3,23), rand(0,59));

        $updated = $this->faker->dateTimeBetween($created, new DateTime('-4 months'));
        $updated->setTime(rand(3,23), rand(0,59));
        

        $var = [
            'is_active' => $this->faker->boolean(80),
            'created_at' => $created->format('Y-m-d H:i:s'),
            'updated_at' => rand(0,10)<3 ? $updated->format('Y-m-d H:i:s') : null,
            'deleted_at' => null,
        ];
        return $var;
    }

    
    
}
