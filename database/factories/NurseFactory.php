<?php

namespace Database\Factories;

use App\Models\Nurse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nurse::class;

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
            //'imageUrl' => $this->faker->,
            // 'rating' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'contact' => $this->faker->numberBetween(10000000, 100000000),

            'pricePer8Hour' => $this->faker->numberBetween(40, 60),
            'pricePer12Hour' => $this->faker->numberBetween(60, 80),
            'pricePer24Hour' => $this->faker->numberBetween(80, 100),

            'latitude' => $this->faker->randomElement([
                "33.848427", "33.858427", "33.868427", "33.878427",
                "33.832427", "33.828427", "33.818427", "33.871427",
                "33.841427", "33.842427", "33.838427", "33.838427"
            ]),
            'longitude' => $this->faker->randomElement([
                "35.518832", "35.528832", "35.538832", "35.548832",
                "35.558832", "35.568832", "35.578832", "35.588832",
                "35.511832", "35.512832", "35.513832", "35.514832"
            ]),
            'user_id' => User::factory(['role' => 'nurse'])
        ];
    }
}
