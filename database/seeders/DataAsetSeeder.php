<?php

namespace Database\Seeders;

use App\Models\DataAset;
use Illuminate\Database\Seeder;

class DataAsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataAset::factory(10)->create();
    }
}
