<?php

namespace Database\Factories;

use App\Models\DataBarang;
use App\Models\PenanggungJawab;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailAsetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pj = PenanggungJawab::all()->random();
        $detailBarang = DataBarang::all()->random();
        $arrayValues = ['Baik', 'RusakRingan', 'RusakBerat'];
        return [
            'kode_aset' => $this->faker->unique()->numerify('#####'),
            'serial_number' => $this->faker->unique()->numerify('######'),
            'kaategori_aset' => $this->faker->jobTitle(),
            'tahun_perolehan' => $this->faker->year(),
            'kondisi' => $arrayValues[rand(0, 1)],
            'deskripsi_aset' => $this->faker->titleFemale(),
            'lokasi' => $this->faker->address(),
            'idPenanggungJawab' => $pj->id,
            'idDetailBarang' => $detailBarang->id,
        ];
    }
}
