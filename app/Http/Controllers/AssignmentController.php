<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Chapter;
use App\Models\Student;
use App\Models\Submission;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AssignmentController extends Controller
{
    /**
     * Show an assignment for the authenticated student
     *
     * @param int $id Id of the assignment
     * @return \Illuminate\Http\Response
     */
    public function studentShow($id){
        $assignment = Assignment::find($id);
        $this->authorize('studentView', $assignment);
        
        $studentAssignment = Assignment::find($id)->studentAssignmentByStudent(Auth::id());
        $submissions = $studentAssignment ? $studentAssignment->submissions : [];
    
        return view('student.assignment', [
            'assignment'=>$assignment,
            'submissions'=>$submissions,
            'studentAssignment'=>$studentAssignment
        ]);
    }

    /**
     * Show an assignment for the authenticated teacher
     *
     * @param int $id Id of the assignment
     * @return \Illuminate\Http\Response
     */
    public function teacherShow($id){
        $assignment = Assignment::find($id);

        $this->authorize('teacherView', $assignment);
    
        return view('teacher.assignment.show', [
            'assignment'=>$assignment,
        ]);
    }

    /**
     * Show form to create a new assignment
     *
     * @param int $id Chapter id
     * @return \Illuminate\Http\Response
     */
    public function teacherCreate(int $id){
        $teacher = Teacher::find(Auth::id());
        $chapter = Chapter::find($id);

        ///$this->authorize('create',  [Assignment::class, $chapter]);
        $plan = $teacher->currentSubscriptionPlan();
         
        //rediriger si aucune souscription ou si limite atteinte
        if ($plan === null){
            return redirect( route('chapter_teacherShow', $id)) 
                ->with('flash_modal', 'You do not have an active subscription. 
                    Please choose one of our subscription plans, or renew your previous subscription.');
        } else if (count($chapter->course->assignments) >=  $plan->nb_assignments){
            return redirect( route('chapter_teacherShow', $id))
                ->with('flash_modal', 'You have reached your subscription limit! Please upgrade to a subscription 
                    with a higher number of assignments allowed, or delete one of your current assignments.
                    Please be aware that this will remove all associated data, such as student attempts, marks, etc.');
        }

        
        return view('teacher.assignment.create', [
            'chapter' => $chapter, 
            'plan' => $plan
        ]);
    }

    /**
     * Save new assignment
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id Chapter id
     * @return \Illuminate\Http\Response
     */
    public function teacherStore(Request $request, int $id){
        $teacher = Teacher::find(Auth::id());
        $chapter = Chapter::find($id);
        $this->authorize('store',  [Assignment::class, $chapter]);
        //form validation
        $rules = [
            'title' => 'required|max:100',
            'description' => 'required|max:65535',
            'submissions' => 'required|int|min:1|max:'.$teacher->currentSubscriptionPlan()->nb_submissions,
            'max-mark' => 'required|max:500|min:0',
            'weight' => 'required|max:100|min:0',
            'start' => 'required|date',
            'end' => 'required|date|after:start',            
            'script' => 'max:65535',
            'executable' => 'required_with:script'
        ];
        if($request->post('executable')== 'on' || !empty($request->post('script'))){
            $rules['language'] = [
                'required',
                Rule::in(['javascript', 'python']),
            ];
        } else {
            $rules['language'] = [
                'nullable',
                Rule::in(['css', 'html', 'javascript', 'python', 'json', 'xml']),
            ];
        }
        $messages = [];
        //skills validation
        if(!empty($request->post('skills'))){
            foreach($request->post('skills') as $skillId => $val) { 
                $rules['skills.'.$skillId] = Rule::in($chapter->course->skills->pluck('id')); 
                $messages['skills.'.$skillId.'.in'] ='Invalid skills selection';
            }
        }
        $validated = $request->validate($rules);
         try { 
            //create assignment
            $assignment = Assignment::create([
                'course_id'=>$chapter->course->id,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'nb_submissions' => $validated['submissions'],
                'test_script' => $validated['script'],
                'max_mark'=>$validated['max-mark'],
                'course_weight'=>$validated['weight'],
                'start_time'=>$validated['start'],
                'end_time'=>$validated['end'],
                'is_test'=>$request->post('test')==='on' ? 1 : 0,
                'can_execute'=>$request->post('executable')==='on' ? 1 : 0,
                'submission_size'=> $teacher->currentSubscriptionPlan()->max_upload_size,
                'language'=>$validated['language'],
            ]);
            //attach skills
            if(!empty($validated['skills'])){
                $assignment->skills()->attach($validated['skills']);
            }
            
            //attach chapter
            $assignment->chapters()->attach($id);
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect( route('chapter_teacherShow', $id) )->with('flash_modal', 
                "Something went wrong and we're sorry to say your new assignment could not be created");    
        }
        return redirect(route('assignment_teacherShow', $assignment->id));
    }

    /**
     * Show edit form for the authenticated teacher
     *
     * @param int $id Id of the assignment
     * @return \Illuminate\Http\Response
     */
    public function teacherEdit(int $id){
        $assignment = Assignment::find($id);

        $this->authorize('update', $assignment);
        return view('teacher.assignment.edit', [
            'assignment'=>$assignment,
        ]);
    }

    /**
     * Save changes to an assignment
     *      
     * @param int $id Id of the assignment
     * @return \Illuminate\Http\Response
     */
    public function teacherUpdate(Request $request, int $id){
        $teacher = Teacher::find(Auth::id());
        $assignment = Assignment::find($id);

        //dd($request->post());
 
        $this->authorize('update', $assignment);
        
        //form validation
        $rules = [
            'title' => 'required|max:100',
            'description' => 'required|max:65535',
            'submissions' => 'required|int|max:'.$teacher->currentSubscriptionPlan()->nb_submissions,
            'max-mark' => 'required|max:500',
            'weight' => 'required|max:100',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            //'size' => 'max:'.$teacher->currentSubscriptionPlan()->max_upload_size,
            
            'script' => 'max:65535',
            'executable' => 'required_with:script'
        ];
        if($request->post('executable')== 'on' || !empty($request->post('script'))){
            $rules['language'] = [
                'required',
                Rule::in(['javascript', 'python', 'php']),
            ];
        } else {
            $rules['language'] = [
                'nullable',
                Rule::in(['css', 'html', 'javascript', 'python', 'json', 'php', 'xml']),
            ];
        }

        $messages = [];
        //skills validation
        if(!empty($request->post('skills'))){
            foreach($request->post('skills') as $skillId => $val) { 
                $rules['skills.'.$skillId] = Rule::in($assignment->course->skills->pluck('id')); 
                $messages['skills.'.$skillId.'.in'] ='Invalid skills selection';
            }
        }

        
        $validated = $request->validate($rules, $messages);

         try { 
            //create chapter
            $assignment->title = $validated['title'];
            $assignment->description = $validated['description'];
            $assignment->nb_submissions = $validated['submissions'];
            $assignment->test_script = $validated['script'];
            $assignment->max_mark = $validated['max-mark'];
            $assignment->course_weight = $validated['weight'];
            $assignment->start_time = date('Y-m-d H:i:s', strtotime($validated['start']));
            $assignment->end_time = date('Y-m-d H:i:s', strtotime($validated['end']));
            $assignment->is_test = $request->post('test')==='on' ? 1 : 0;
            $assignment->can_execute = $request->post('executable')==='on' && $validated['language'] ? 1 : 0;
            $assignment->submission_size = $teacher->currentSubscriptionPlan()->max_upload_size;
            $assignment->language = $validated['language'];

            $assignment->save();

            //attach skills
            if(!empty($validated['skills'])){
                $assignment->skills()->sync($validated['skills']);
            } else {
                $assignment->skills()->detach();
            }


        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception);
            return redirect( route('chapter_teacherShow', $assignment->chapters[0]->id) )->with('flash_modal', "Something went wrong and we're sorry to say your changes could not be saved");    
        }
        return view('teacher.assignment.show', [
            'assignment'=>$assignment,
        ]);
    }

    /**
     * Shows the confirmation page for deletion
     * 
     * @param int $id Assignment Id
     * @return \Illuminate\Http\Response
     */
    public function teacherConfirmDelete($id){
        $assignment = Assignment::find($id);
        if(empty($assignment)){
            return redirect(route('course_teacherIndex'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $assignment);
        $message = "<p>You have chosen to delete the following assignment: <strong>".$assignment->title."</strong></p>";
        $message .= "<ul><li>Course: ".$assignment->course->title."</li><li>Chapter: ".$assignment->chapters[0]->title."</li></ul>";
        $message .= "<p>Please be aware that this will remove all associated data, such as student attempts, marks, assignment notes, etc.</p>";
        $message .= "<p>Sure you want to delete ?</p>";
        return view('teacher.confirmDelete', [
            'route'=> route('assignment_teacherDelete', $id),
            'message'=>$message,
            'backRoute'=> route('assignment_teacherShow', $id),
            'resource'=>'assignment'
        ]);
    }

    /**
     * Soft Deleted the assignment
     * 
     * @param int $id Assignment Id
     * @return \Illuminate\Http\Response
     */
    public function teacherDelete($id){
        $assignment = Assignment::find($id);
        if(empty($assignment)){
            return redirect(route('course_teacherIndex'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $assignment);

        $deleted = $assignment->delete();
        if ($deleted){
            return redirect(route('chapter_teacherShow', $assignment->chapters[0]->id))->with('success', 'Assignment Deleted');
        } else {
            return redirect(route('chapter_teacherShow', $assignment->chapters[0]->id))->with('error', 'Assignment Could not be Deleted');
        }
    }

    /**
     * Get the test script for an assignment
     * 
     * @param int $id Assignment Id
     * @return \Illuminate\Http\Response
     */
    public function studentTestScript(Request $request , $id){
        if($request->ajax()) {
            //check teacher has room in subscription
            $assignment = Assignment::find($id);
            $student = Student::find(Auth::id());
            if ($student === null || empty($assignment)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'An error occured'
                ], 403);
            } else if ($request->user()->cannot('studentView', $assignment)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'You do not have permission to access this resource.'
                ], 403);
            }

            return response()->json([
                'success' => true, 
                'script' => $assignment->test_script
            ], 200);
        }
    }
}
