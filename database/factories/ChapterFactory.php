<?php

namespace Database\Factories;

use App\Models\Chapter;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chapter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $created = $this->faker->dateTimeBetween(new DateTime('-3 months'), new DateTime('-2 months'));
        return [
            'is_active' => $this->faker->boolean(80),
            'created_at' => $created,
            'updated_at' => rand(0,10)<3 ? $this->faker->dateTimeBetween($created, new DateTime('-2 months')) : null,
            'deleted_at' => null,
        ];
    }
}
