<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nurse_id' => Nurse::factory(),
            'availability' => $this->faker->randomElement(['monday1', 'monday2', 'monday0', 'monday18', 'tuesday13'])
        ];
    }
}
