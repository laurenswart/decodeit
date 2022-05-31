<?php

namespace Database\Seeders;

use App\Models\StudentAssignment;
use App\Models\Submission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Submission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $studentAssignments = StudentAssignment::all();
        foreach($studentAssignments as $studentAssignment){
            $nbSubmissions = rand(1,$studentAssignment->assignment->nb_submissions);
            Submission::factory()->assignment($studentAssignment->assignment)->count($nbSubmissions)->create([
                'student_assignment_id' => $studentAssignment->id,
            ]);
        }
        
    }
}
