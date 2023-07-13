<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use Illuminate\Database\Seeder;

class DataBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataBarang::factory(5)->create();
    }
}
