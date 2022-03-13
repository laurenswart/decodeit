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
            ->count(700)
            ->create();
        // INSERT TEACHERS
        User::factory()->role('teacher')
            ->count(50)
            ->create();

        
        //Constant users for testing
        User::factory()->create([
            'firstname'=>'lauren', 
            'lastname'=>'swart', 
            'email'=>'lswart@gmail.com', 
            'role_ref'=>2
        ]);
        User::factory()->create([
            'firstname'=>'bob', 
            'lastname'=>'sull', 
            'email'=>'bsull@gmail.com', 
            'role_ref'=>1
        ]);
    }
}
