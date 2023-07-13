<?php

namespace Database\Factories;

use App\Models\JenisBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $jenisBarang = JenisBarang::all()->random();
        return [
            'kode_barang' => $this->faker->unique()->numerify('#####'),
            'nama_barang' => $this->faker->name(),
            'tipe' => $this->faker->jobTitle(),
            'merk' => $this->faker->citySuffix(),
            'idJenisBarang' => $jenisBarang->id,
        ];
    }
}
