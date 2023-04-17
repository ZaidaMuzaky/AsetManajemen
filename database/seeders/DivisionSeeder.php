<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'nama_divisi' => 'Tecnology & Quality Control',
            ],
            [
                'id' => '5',
                'nama_divisi' => 'Deputy GM Sub Quality Control',
            ],
            [
                'id' => '2',
                'nama_divisi' => 'Operation',
            ],
            [
                'id' => '3',
                'nama_divisi' => 'Finance',
            ],
            [
                'id' => '4',
                'nama_divisi' => 'Human Resource & General Affairs',
            ],
        ];
        DB::table('division')->insert($data);
    }
}
