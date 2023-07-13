<?php

namespace Database\Factories;

use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenanggungJawabFactory extends Factory
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
            'nip' => $this->faker->unique()->numerify('#####'),
            'nama' => $this->faker->name(),
            'id_divisi' => $divisi->id,
        ];
    }
}
