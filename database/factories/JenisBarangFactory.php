<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JenisBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Kode_Jenis_Barang' =>  $this->faker->unique()->numerify('#####'),
            'Jenis_Barang' => $this->faker->jobTitle(),
        ];
    }
}
