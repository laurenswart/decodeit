<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class SubmissionController extends Controller
{

    /**
     * Create a new submission
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Assignment id
     * @return \Illuminate\Http\Response 
     */
    public function studentStore(Request $request, $id){

        //validate form content
        $rules = [
            'script' => 'required|max:65535',
            'console' => 'max:65535',
        ];
        $validated = $request->validate($rules);
        //todo validate weight of script

        //check if student has already a student_attempt
        $student = Student::find(Auth::id()); 
        $assignment = Assignment::find($id);

        $this->authorize('create', [Submission::class, $assignment]);

        $enrolment = DB::table('enrolments')->where('course_id', $assignment->course_id)->where('student_id', $student->id)->first();
        $studentAssignment = DB::table('student_assignment')->where('assignment_id', $id)->where('enrolment_id', $enrolment->id)->first();

        //create new student assignment if not exists
        if(empty($studentAssignment)){
            $studentAssignmentId = DB::table('student_assignment')->insertGetId([
                'enrolment_id'=>$enrolment->id,
                'assignment_id'=>$assignment->id,
            ]);
            $studentAssignment = DB::table('student_assignment')->find($studentAssignmentId);
        }
        //dd($validated);

        //save submission
        Submission::create([
            'student_assignment_id'=>$studentAssignment->id, 
            'content'=>$validated['script'],
            'console'=>$validated['console']
        ]);

        return redirect(route('assignment_studentShow', $id));

        
        
        dd($request->post());

    }

    /**
     * 
     * @param int $id Submission Id 
     */
    public function studentAddQuestion(Request $request, int $id){
        if($request->ajax() &&  $request->post('question')) {
            //validate question
            if(empty($request->post('question'))){
                return response()->json([
                    'success' => false, 
                    'msg' => 'No question received'
                ], 400);
            }

            //find submission
            $student = Student::find($request->user()->id);
            if(empty($student)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'User not found.'
                ], 500);
            }
            $submission = Submission::find($id);
            if ($submission === null || $request->user()->cannot('studentAddQuestion',$submission)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'Unauthorized action'
                ], 403);
            }

            //save question
            $submission->question =  $request->post('question');
            $submission->save();

            if($submission->wasChanged('question')){
                return response()->json([
                    'success' => true,
                ], 200);
            } else {
                return response()->json([
                    'success' => false, 
                    'msg' => 'Oops, Something went wrong.'
                ], 500);
            }

           
        }
    }
}
