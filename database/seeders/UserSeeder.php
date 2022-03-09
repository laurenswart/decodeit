<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the table first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // INSERT STUDENTS
        User::factory()
            ->count(105)
            ->create();
        User::factory()->role('teacher')
            ->count(7)
            ->create();

        
        //Define data
        $users = [
            //teachers
            ['firstname'=>'lauren', 'lastname'=>'swart', 'email'=>'lswart@gmail.com', 'role_ref'=>2],
            //students
            ['firstname'=>'bob', 'lastname'=>'sull', 'email'=>'bsull@gmail.com', 'role_ref'=>1],
        ];

        foreach($users as &$user){
            //set password
            $user['password'] = '$2y$10$FacC.79UhaeugQhEEQRDquwRe97jsgBFk2/C7I.EEuZKFFs7NodfS';
            $user['created_at'] = $user['created_at'] ?? date("Y-m-d H:i:s", mktime(14, 35, 22, 1, 24, 2022)); 
            $user['updated_at'] = $user['updated_at'] ?? now(); 
        }
        
        //Insert data in the table
        DB::table('users')->insert($users);
    }
}
