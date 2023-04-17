<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipePegawaiSeeder extends Seeder
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
                'kode_tipe_pegawai' => '61',
                'nama_tipe_pegawai' => 'PKWT REKA',
            ],
            [
                'kode_tipe_pegawai' => '64',
                'nama_tipe_pegawai' => 'PKWT INKA',
            ],
            [
                'kode_tipe_pegawai' => '94',
                'nama_tipe_pegawai' => 'Organik REKA',
            ],
            [
                'kode_tipe_pegawai' => '99',
                'nama_tipe_pegawai' => 'Organik INKA',
            ],
        ];
        DB::table('tipe_pegawai')->insert($data);
    }
}
