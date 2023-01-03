<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LaptopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'merk' => $this->faker->randomElement(['Asus', 'Acer', 'Lenovo']),
            'spesifikasi' => $this->faker->sentence(5)
        ];
    }
}
