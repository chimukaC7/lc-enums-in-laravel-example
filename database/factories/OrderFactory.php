<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total' => $this->faker->numberBetween(100, 100000),
            'status' => $this->faker->numberBetween(1, 4),
            'created_at' => $this->faker->dateTimeBetween('-30 days', now()),
        ];
    }
}
