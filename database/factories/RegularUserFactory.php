<?php

namespace Database\Factories;

use App\Models\RegularUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegularUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RegularUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->word(),
            'lastName' => $this->faker->word(),

            'latitude' => $this->faker->randomElement([
                "33.848427", "33.858427", "33.868427", "33.878427",
                "33.841427", "33.842427", "33.838427", "33.838427"
            ]),
            'longitude' => $this->faker->randomElement([
                "35.518832", "35.528832", "35.538832", "35.548832",
                "35.511832", "35.512832", "35.513832", "35.514832"
            ]),
            'user_id' => User::factory(['role' => 'regular'])
        ];
    }
}
