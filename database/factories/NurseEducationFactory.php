<?php

namespace Database\Factories;

use App\Models\NurseEducation;
use App\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseEducationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NurseEducation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'school' => $this->faker->word(),
            'degree' => $this->faker->word(),
            'graduationYear' => $this->faker->numberBetween(1950, 2020),
            'nurse_id' => Nurse::factory()
        ];
    }
}
