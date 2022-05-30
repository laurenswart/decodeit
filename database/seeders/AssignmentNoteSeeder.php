<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        AssignmentNote::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //find assignments
        $assignments = Assignment::all();

        foreach($assignments as $assignment){
            //create random amount of notes
            $nbNotes = rand(0,3);
            if($nbNotes==0) continue;
            
            AssignmentNote::factory()->count($nbNotes)->create([
                'assignment_id' => $assignment->id,
            ]);
        }
    }
}
