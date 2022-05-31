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
            'firstname'=>'Lauren', 
            'lastname'=>'Swart', 
            'email'=>'lswart@gmail.com', 
            'role_id'=>2
        ]);
    }
}
