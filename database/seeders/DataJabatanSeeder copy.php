<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataJabatanSeeder extends Seeder
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
                'kode_jabatan' => 'RK_J_00',
                'nama_jabatan' => 'Belum Ada',
                'status' => 'Aktif'
            ],
            [
                'kode_jabatan' => 'RK_J_01',
                'nama_jabatan' => 'Direktur',
                'status' => 'Aktif'
            ],
            [
                'kode_jabatan' => 'RK_J_02',
                'nama_jabatan' => 'Supervisor',
                'status' => 'Aktif'
            ],
            [
                'kode_jabatan' => 'RK_J_03',
                'nama_jabatan' => 'Manajer',
                'status' => 'Aktif'
            ],
            [
                'kode_jabatan' => 'RK_J_04',
                'nama_jabatan' => 'Staff',
                'status' => 'Aktif'
            ],
        ];
        DB::table('jabatan')->insert($data);
    }
}
