<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
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
                'nip' => '6120000002',
                'nama' => 'Arif Arfi',
                'jenis_kelamin' => 'Laki-Laki',
                'kode_jabatan' => '1',
            ],
            [
                'id_kepegawaian' => '64',
                'tahun_sk' => '20',
                'no_urut_pegawai' => '000001',
                'nama_lengkap' => 'Gusti Juno',
            ],
            [
                'id_kepegawaian' => '61',
                'tahun_sk' => '20',
                'no_urut_pegawai' => '000002',
                'nama_lengkap' => 'Arif Arfi',
            ],
        ];
        DB::table('nip')->insert($data);
    }
}
