<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('admins')->truncate();

        $rows = [[
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('epfcEPFC123!'),

            ]  
        ];

        DB::table('admins')->insert($rows);
    }
}
