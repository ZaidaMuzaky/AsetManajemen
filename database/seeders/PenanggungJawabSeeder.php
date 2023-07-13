<?php

namespace Database\Seeders;

use App\Models\PenanggungJawab;
use Illuminate\Database\Seeder;

class PenanggungJawabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PenanggungJawab::factory(5)->create();
    }
}
