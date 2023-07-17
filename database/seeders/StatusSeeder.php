<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['value' => 'Baik', 'nama' => 'Baik', 'color' => 'success'],
            ['value' => 'RusakRingan', 'nama' => 'Rusak Ringan', 'color' => 'warning'],
            ['value' => 'RusakBerat', 'nama' => 'Rusak Berat', 'color' => 'danger'],
        ];
        DB::table('status')->insert($data);
    }
}
