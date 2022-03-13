<?php

namespace Database\Factories;

use App\Models\Course;
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
        $created = $this->faker->dateTimeBetween(new DateTime('-5 months'), new DateTime('-4 months'));
        return [
            'is_active' => $this->faker->boolean(80),
            'created_at' => $created,
            'updated_at' => rand(0,10)<3 ? $this->faker->dateTimeBetween($created, new DateTime('-4 months')) : null,
            'deleted_at' => null,
        ];
    }

    
    
}
