<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Student;
use App\Models\Submission;
use App\Models\Teacher;
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
        $student = Student::find(Auth::id()); 
        $assignment = Assignment::find($id);
        
        //authorize action
        $this->authorize('create', [Submission::class, $assignment]);

        //validate form content
        $rules = [
            'script' => 'required|max:65535',
            'console' => 'max:65535',
        ];
        $validated = $request->validate($rules);

        //check if student has already a student_attempt
        $enrolment = DB::table('enrolments')
                ->where('course_id', $assignment->course_id)
                ->where('student_id', $student->id)
                ->first();
        $studentAssignment = DB::table('student_assignment')
                ->where('assignment_id', $id)
                ->where('enrolment_id', $enrolment->id)
                ->first();

        //create new student assignment if not exists
        if(empty($studentAssignment)){
            $studentAssignmentId = DB::table('student_assignment')->insertGetId([
                'enrolment_id'=>$enrolment->id,
                'assignment_id'=>$assignment->id,
            ]);
            $studentAssignment = DB::table('student_assignment')->find($studentAssignmentId);
        }
        //save submission
        Submission::create([
            'student_assignment_id'=>$studentAssignment->id, 
            'content'=>$validated['script'],
            'console'=>$validated['console'],
            'status'=>'ran'
        ]);

        return redirect(route('assignment_studentShow', $id));
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

    /**
     * 
     * @param int $id Submission Id 
     */
    public function teacherUpdateFeedback(Request $request, int $id){
        if($request->ajax()) {
            //find submission
            $teacher = Teacher::find($request->user()->id);
            if(empty($teacher)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'User not found.'
                ], 500);
            }
            $submission = Submission::find($id);
            if ($submission === null || $request->user()->cannot('teacherUpdate',$submission)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'Unauthorized action'
                ], 403);
            }

            //save question
            $submission->feedback =  $request->post('feedback') ?? '';
            $submission->feedback_at =  now();
            $submission->save();

            if($submission->wasChanged('feedback')){
                return response()->json([
                    'success' => true,
                    'feedback'=> $submission->feedback ?? ''
                ], 200);
            } else {
                return response()->json([
                    'success' => false, 
                    'msg' => 'Oops, Something went wrong.'
                ], 500);
            }

           
        }
        return response()->json($request->post());
    }
}
