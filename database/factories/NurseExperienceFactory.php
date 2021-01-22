<?php

namespace Database\Factories;

use App\Models\NurseExperience;
use App\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NurseExperience::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position' => $this->faker->word(),
            'employmentType' => $this->faker->word(),
            'company' => $this->faker->word(),
            'startYear' => $this->faker->numberBetween(1950, 2020),
            'EndYear' => $this->faker->numberBetween(1950, 2020),
            'nurse_id' => Nurse::factory()
        ];
    }
}
