<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartemenSeeder extends Seeder
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
                'nama_departemen' => 'Engineering Information Management',
            ],
            [
                'nama_departemen' => 'Electrical Design',
            ],
            [
                'nama_departemen' => 'Mechanical Design',
            ],
            [
                'nama_departemen' => 'Production Technology',
            ],
            [
                'nama_departemen' => 'Incoming Quality Control',
            ],
            [
                'nama_departemen' => 'In Process Inspection',
            ],
            [
                'nama_departemen' => 'Final Inspection',
            ],
            [
                'nama_departemen' => 'After Sales',
            ],
            [
                'nama_departemen' => 'Purchasing',
            ],
            [
                'nama_departemen' => 'Logistic Controlling',
            ],
            [
                'nama_departemen' => 'Expedition Sub',
            ],
            [
                'nama_departemen' => 'Warehouse',
            ],
            [
                'nama_departemen' => 'Warehouse Candi Sewu Sub',
            ],
            [
                'nama_departemen' => 'Warehouse Sukosari Sub',
            ],
            [
                'nama_departemen' => 'Production Planning and Controlling',
            ],
            [
                'nama_departemen' => 'Production Workshop Candi Sewu',
            ],
            [
                'nama_departemen' => 'Production Workshop Sukosari',
            ],
            [
                'nama_departemen' => 'Production Workshop INKA',
            ],
            [
                'nama_departemen' => 'Maintenance',
            ],
            [
                'nama_departemen' => 'Bidding & Pricing',
            ],
            [
                'nama_departemen' => 'Tax & Verification',
            ],
            [
                'nama_departemen' => 'Accounting & Budgeting',
            ],
            [
                'nama_departemen' => 'Treasury & Fund Raising',
            ],
            [
                'nama_departemen' => 'HR & General Affairs',
            ],
            [
                'nama_departemen' => 'Corporate Secretary & Legal',
            ],
            [
                'nama_departemen' => 'Information Technology',
            ],
        ];
        DB::table('unit_kerja')->insert($data);
    }
}
