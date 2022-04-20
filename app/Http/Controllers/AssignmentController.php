<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Chapter;
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
    
        return view('student.assignment', [
            'assignment'=>$assignment,
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
        
        //if no more available chapters in subscription
        $teacher = Teacher::find(Auth::id());
        $chapter = Chapter::find($id);
        //dd($chapter->course->teacher_id);

        $this->authorize('create',  [Assignment::class, $chapter]);
        $plan = $teacher->currentSubscriptionPlan();
         
        if ($plan === null){
            return redirect( route('chapter_teacherShow', $id)) 
                ->with('flash_modal', 'You do not have an active subscription. Please choose one of our subscription plans, or renew your previous subscription.');
        } else if (count($chapter->course->assignments) >=  $plan->nb_assignments){
            return redirect( route('course_teacherShow', $id))
                ->with('flash_modal', 'You have reached your subscription limit! Please upgrade to a subscription with a higher number of assignments allowed, or delete one of your current assignments.
                    Please be aware that this will remove all associated data, such as student attempts, marks, etc.');
        }
        return view('teacher.assignment.create', ['chapter'=>$chapter]);
    }

    /**
     * Save new assignment
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id Chapter id
     * 
     * @return \Illuminate\Http\Response
     */
    public function teacherStore(Request $request, int $id){
        $teacher = Teacher::find(Auth::id());
        $chapter = Chapter::find($id);

        //dd($request->post());
 
        $this->authorize('store',  [Assignment::class, $chapter]);

        //form validation
        $rules = [
            'title' => 'required|max:100',
            'description' => 'required|max:65535',
            'submissions' => 'required|max:'.$teacher->currentSubscriptionPlan()->nb_submissions,
            'max-mark' => 'required|max:500',
            'weight' => 'required|max:100',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'size' => 'max:'.$teacher->currentSubscriptionPlan()->max_upload_size,
            'language' => [
                'required_with:script',
                Rule::in(['css', 'html', 'javascript', 'python', 'java', 'json', 'php', 'xml']),
            ],
            'script' => 'max:65535',
            'executable' => 'required_with:script'
        ];
        //skills validation
        if(!empty($request->post('skills'))){
            foreach($request->post('skills') as $skillId => $val) { 
                $rules['skills.'.$skillId] = Rule::in($chapter->course->skills->pluck('id')); 
            }
        }

        $validated = $request->validate($rules);

         try { 
            //create chapter
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
                'submission_size'=>$validated['size'] ?? $teacher->currentSubscriptionPlan()->max_upload_size,
                'language'=>$validated['language'],
            ]);

            //attach skills
            $assignment->skills()->attach($validated['skills']);
            //attach chapter
            $assignment->chapters()->attach($id);

        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception);
            return redirect( route('chapter_teacherShow', $id) )->with('flash_modal', "Something went wrong and we're sorry to say your new assignment could not be created");    
        }
        return view('teacher.assignment.show', [
            'assignment'=>$assignment,
        ]);
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
            'submissions' => 'required|max:'.$teacher->currentSubscriptionPlan()->nb_submissions,
            'max-mark' => 'required|max:500',
            'weight' => 'required|max:100',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'size' => 'max:'.$teacher->currentSubscriptionPlan()->max_upload_size,
            'language' => [
                'required_with:script',
                Rule::in(['css', 'html', 'javascript', 'python', 'java', 'json', 'php', 'xml']),
            ],
            'script' => 'max:65535',
            'executable' => 'required_with:script'
        ];
        //skills validation
        if(!empty($request->post('skills'))){
            foreach($request->post('skills') as $skillId => $val) { 
                $rules['skills.'.$skillId] = Rule::in($assignment->course->skills->pluck('id')); 
            }
        }

        $validated = $request->validate($rules);

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
            $assignment->can_execute = $request->post('executable')==='on' ? 1 : 0;
            $assignment->submission_size = $validated['size'] ?? $teacher->currentSubscriptionPlan()->max_upload_size;
            $assignment->language = $validated['language'];

            $assignment->save();

            //attach skills
            $assignment->skills()->sync($validated['skills']);


        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception);
            return redirect( route('chapter_teacherShow', $id) )->with('flash_modal', "Something went wrong and we're sorry to say your changes could not be created");    
        }
        return view('teacher.assignment.show', [
            'assignment'=>$assignment,
        ]);
    }
}
