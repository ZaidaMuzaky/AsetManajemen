<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
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
                'kode_divisi' => '61',
                'nama_divisi' => 'divisi 1 REKA',
            ],
            [
                'kode_divisi' => '64',
                'nama_divisi' => 'divisi 2 INKA',
            ],
            [
                'kode_divisi' => '94',
                'nama_divisi' => 'divisi 3 REKA',
            ],
            [
                'kode_divisi' => '99',
                'nama_divisi' => 'divisi 4 Reka',
            ],
        ];
        DB::table('divisi')->insert($data);
    }
}
