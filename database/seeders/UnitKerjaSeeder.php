<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
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
                'division_id' => '1',
                'nama_unit_kerja' => 'Engineering dan Engineering Information Management',
            ],
            [
                'division_id' => '1',
                'nama_unit_kerja' => 'Electrical Design',
            ],
            [
                'division_id' => '1',
                'nama_unit_kerja' => 'Mechanical Design',
            ],
            [
                'division_id' => '1',
                'nama_unit_kerja' => 'Production Technology',
            ],
            [
                'division_id' => '1',
                'nama_unit_kerja' => 'Bidding & Pricing',
            ],
            [
                'division_id' => '5',
                'nama_unit_kerja' => 'Incoming Quality Control',
            ],
            [
                'division_id' => '5',
                'nama_unit_kerja' => 'In Process Inspection',
            ],
            [
                'division_id' => '5',
                'nama_unit_kerja' => 'Final Inspection',
            ],
            [
                'division_id' => '5',
                'nama_unit_kerja' => 'After Sales',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Purchasing',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Logistic Controlling',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Expedition Sub',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Warehouse',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Warehouse Candi Sewu Sub',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Warehouse Sukosari Sub',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Production Planning and Controlling',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Production Workshop Candi Sewu',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Production Workshop Sukosari',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Production Workshop INKA',
            ],
            [
                'division_id' => '2',
                'nama_unit_kerja' => 'Maintenance',
            ],

            [
                'division_id' => '3',
                'nama_unit_kerja' => 'Tax & Verification',
            ],
            [
                'division_id' => '3',
                'nama_unit_kerja' => 'Accounting & Budgeting',
            ],
            [
                'division_id' => '3',
                'nama_unit_kerja' => 'Treasury & Fund Raising',
            ],
            [
                'division_id' => '4',
                'nama_unit_kerja' => 'HR & General Affairs',
            ],
            [
                'division_id' => '4',
                'nama_unit_kerja' => 'Corporate Secretary & Legal',
            ],
            [
                'division_id' => '4',
                'nama_unit_kerja' => 'Information Technology',
            ],
        ];
        DB::table('unit_kerja')->insert($data);
    }
}
