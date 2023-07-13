<?php

namespace Database\Factories;

use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataAsetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $divisi = Divisi::all()->random();
        return [
            'nomor' => $this->faker->unique()->numerify('#####'),
            'nama' => $this->faker->name(),
            'perusahaan' => 'REKA',
            'id_divisi' => $divisi->id,
            'tahun' => $this->faker->year(),
            'kondisi' => 'Baik'
        ];
    }
}
