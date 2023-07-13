<?php

namespace Database\Seeders;

use App\Models\DetailAset;
use Illuminate\Database\Seeder;

class DetailAsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetailAset::factory(10)->create();
    }
}
