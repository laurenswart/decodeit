<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Skill;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    
    /**
     * Show courses for the authenticated student
     *
     * @return \Illuminate\Http\Response
     */
    public function studentIndex(){
        $this->authorize('studentViewAny', Course::class);
        
        $courses = Student::find(Auth::id())->courses
            ->whereNull('deleted_at');

        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->whereIn('course_id', $courses->pluck('id'));

        return view('student.courses', [
            'courses'=>$courses,
            'assignments'=>$assignments
        ]);
    }

    /**
     * Show courses for the authenticated teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherIndex(){
        $this->authorize('teacherViewAny', Course::class);

        $courses = Teacher::find(Auth::id())->courses
            ->whereNull('deleted_at');

        return view('teacher.course.index', [
            'courses'=>$courses,
        ]);
    }


    /**
     * Show a course for the authenticated student
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function studentShow($id){
        $course = Course::find($id);

        $this->authorize('studentView', $course);

        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->where('course_id', $id)
        ;

        return view('student.course', [
            'course'=>$course,
            'assignments'=>$assignments
        ]);
    }

    /**
     * Show a course for the authenticated teacher
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function teacherShow($id){
        $course = Course::find($id);

        $this->authorize('teacherView', $course);

        $assignments = Assignment::all()
            ->sortBy('start_time')
            ->sortBy('end_time')
            ->where('course_id', $id);

        return view('teacher.course.show', [
            'course'=>$course,
            'assignments'=>$assignments
        ]);
    }

    /**
     * Show form to create a new course
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherCreate(){
        $this->authorize('create', Course::class);
        //if no more available courses in subscription
        //TODO send back to index, with message 
        $teacher = Teacher::find(Auth::id());
        $plan = $teacher->currentSubscriptionPlan();
         
        if ($plan === null){
            return redirect( route('course_teacherIndex')) 
                ->with('flash_modal', 'You do not have an active subscription. Please choose one of our subscription plans, or renew your previous subscription.');
        } else if (count($teacher->courses) >=  $plan->nb_courses){
            return redirect( route('course_teacherIndex'))
                ->with('flash_modal', 'You have reached your subscription limit! Please upgrade to a subscription with a higher number of courses allowed, or delete one of your current courses.
                    Please be aware that this will remove all associated data, such as assignments, student attempts, etc.');
        }
        return view('teacher.course.create');
    }

    /**
     * Save new course
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function teacherStore(Request $request){
        //validate inputs
        $rules = [
            'title' => 'required|max:100',
        ];

        if(!empty($request->post('skills'))){
            foreach($request->post('skills') as $key => $val) { 
                if(empty($val['description'])){
                    $rules['skills.'.$key.'.title'] = 'max:100'; 
                } else {
                    $rules['skills.'.$key.'.title'] = 'required|max:100'; 
                }
                $rules['skills.'.$key.'.description'] = 'max:255'; 

            }
        }
        $validated = $request->validate($rules);

        try { 
            //create course
            $course = Course::create([
                'title' => $validated['title'],
                'is_active' => $request->post('active')==='on' ? 1 : 0,
                'teacher_id' => Auth::id()
            ]);

            //create skills
            if(!empty($validated['skills'])){
                $newSkills = [];
                foreach($validated['skills'] as $skill){
                    if(empty( $skill['title'])){
                        continue;
                    }
                    $newSkills[] = [
                        'course_id' => $course->id,
                        'title' => $skill['title'],
                        'description' => $skill['description'],
                    ];
                }
                if(!empty( $newSkills)){
                    Skill::insert($newSkills);  
                }
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect( route('course_teacherIndex') )->with('flash_modal', "Something went wrong and we're sorry to say your new course could not be created");    
        }
        return redirect( route('course_teacherIndex') );
    }

    /**
     * Show form to edit a course
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function teacherEdit(int $id){
        $course = Course::find($id);

        $this->authorize('update', $course);

        return view("teacher.course.edit", [
            "course" =>$course
        ]);
    }

    /**
     * Save the course
     *
     * @param int $id Id of the course
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function teacherUpdate(Request $request,int $id){
        //find the course to update
        $course = Course::find($id);
        if(empty($course)){
            return redirect( route('course_teacherIndex')) 
                ->with('flash_modal', 'Could not find the course to update.');
        }

        //validate inputs
        $rules = [
            'title' => 'required|max:100',
        ];

        //old skills
        //dd($request->post());
        if($request->post('oldSkills') != null){
            foreach($request->post('oldSkills') as $key => $val) { 
                if(empty($val['description'])){
                    $rules['oldSkills.'.$key.'.title'] = 'max:100'; 
                } else {
                    $rules['oldSkills.'.$key.'.title'] = 'required|max:100'; 
                }
                $rules['oldSkills.'.$key.'.description'] = 'max:255'; 
            }
        }
        //new skills
        if($request->post('skills') != null){
            foreach($request->post('skills') as $key => $val) { 
                if(empty($val['description'])){
                    $rules['skills.'.$key.'.title'] = 'max:100'; 
                } else {
                    $rules['skills.'.$key.'.title'] = 'required|max:100'; 
                }
                $rules['skills.'.$key.'.description'] = 'max:255'; 
            }
        }
        $validated = $request->validate($rules);

        try { 
            //update course details
            $course->title = $validated['title'];
            $course->is_active = $request->post('active')==='on' ? 1 : 0;
            $course->save();

            //create new skills
            if(!empty($validated['skills'])){
                $newSkills = [];
                
                foreach($validated['skills'] as $skill){
                    if(empty( $skill['title'])){
                        continue;
                    }
                    $newSkills[] = [
                        'course_id' => $course->id,
                        'title' => $skill['title'],
                        'description' => $skill['description'],
                    ];
                }
                if(!empty( $newSkills)){
                    Skill::insert($newSkills);  
                }
            }
            //remove old or update old
            if(!empty($validated['oldSkills'])){
                foreach($validated['oldSkills'] as $skillId => $skill){
                    $existingSkill = Skill::find($skillId);
                    if(empty($existingSkill)) continue;

                    if(empty( $skill['title'])){
                        //delete
                        $existingSkill->delete();
                    } else {
                        //update
                        $existingSkill->title = $skill['title'];
                        $existingSkill->description = $skill['description'];
                        $existingSkill->save();
                    }
                }
            }
            
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect( route('course_teacherShow', $id) )->with('status', "Something went wrong and we're sorry to say your new course could not be created");    
        }
        return view("teacher.course.show", [
            'course'=>$course
        ]);
    }
}
