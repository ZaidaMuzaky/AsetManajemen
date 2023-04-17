<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
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
                'nama' => 'Admin',
                'tipe_user' => 'admin',
                'foto' => 'null',
                'email' => 'admin@admin.com',
                'password' => Hash::make('qwe12345')
            ],
            [
                'nama' => 'SuperAdmin',
                'tipe_user' => 'superadmin',
                'foto' => 'null',
                'email' => 'superadmin@admin.com',
                'password' => Hash::make('qwe12345')
            ],
        ];
        DB::table('users')->insert($data);
    }
}
