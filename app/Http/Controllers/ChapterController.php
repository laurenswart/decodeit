<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{

    /**
     * Show a chapter for the authenticated student
     *
     * @param int $id Id of the chapter
     * @return \Illuminate\Http\Response
     */
    public function studentShow($id){
        $chapter = Chapter::find($id);

        $this->authorize('studentView', $chapter);
    
        return view('student.chapter', [
            'chapter'=>$chapter,
        ]);
    }

    /**
     * Show a course for the authenticated teacher
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function teacherShow($id){
        $chapter = Chapter::find($id);

        $this->authorize('teacherView', $chapter);

        $assignments = $chapter->assignments
            ->sortBy('start_time')
            ->sortBy('end_time');

        return view('teacher.chapter.show', [
            'chapter'=>$chapter,
            'assignments'=>$assignments
        ]);
    }

    /**
     * Show form to create a new chapter
     *
     * @param int $id Course id
     * @return \Illuminate\Http\Response
     */
    public function teacherCreate(int $id){
        
        //if no more available chapters in subscription
        $teacher = Teacher::find(Auth::id());
        $course = Course::find($id);
        $plan = $teacher->currentSubscriptionPlan();
        $this->authorize('create', [Course::class, $course ]);
         
        if ($plan === null){
            return redirect( route('course_teacherShow', $id)) 
                ->with('flash_modal', 'You do not have an active subscription. Please choose one of our subscription plans, or renew your previous subscription.');
        } else if (count($course->chapters) >=  $plan->nb_chapters){
            return redirect( route('course_teacherShow', $id))
                ->with('flash_modal', 'You have reached your subscription limit! Please upgrade to a subscription with a higher number of chapters allowed, or delete one of your current chapters.
                    Please be aware that this will remove all associated data, such as assignments, student attempts, etc.');
        }
        return view('teacher.chapter.create', ['course'=>$course]);
    }

    /**
     * Save new chapter
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id Course id
     * 
     * @return \Illuminate\Http\Response
     */
    public function teacherStore(Request $request, int $id){
        //validate inputs
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required|max:65535'
        ];

        //check teacher has this course
        $course = Course::find($id);
        $this->authorize('store', [Chapter::class, $course]);

        $validated = $request->validate($rules);

        $teacher = Teacher::find(Auth::id());


        //dd($validated);
        try { 
            //create chapter
            $chapter = Chapter::create([
                'course_id'=>$id,
                'title' => $validated['title'],
                'is_active' => $request->post('active')==='on' ? 1 : 0,
                'content' => $validated['content'],
                'order_id' => count($teacher->courses)+1
            ]);

        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect( route('course_teacherShow', $id) )->with('flash_modal', "Something went wrong and we're sorry to say your new chapter could not be created");    
        }
        return redirect( route('chapter_teacherShow', $chapter->id) );
    }

    /**
     * Show form to edit a chapter
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function teacherEdit(int $id){
        $chapter = Chapter::find($id);

        $this->authorize('update', $chapter);

        return view("teacher.chapter.edit", [
            "chapter" =>$chapter
        ]);
    }

    /**
     * Save the course
     *
     * @param int $id Id of the chapter
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function teacherUpdate(Request $request,int $id){
        //find the course to update
        $chapter = Chapter::find($id);
        if(empty($chapter)){
            return redirect( route('chapter_teacherIndex')) 
                ->with('flash_modal', 'Could not find the chapter to update.');
        }

        $this->authorize('update', $chapter);

        //validate inputs
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required|max:65535'
        ];

        $validated = $request->validate($rules);

        try { 
            //update chapter details
            $chapter->title = $validated['title'];
            $chapter->is_active = $request->post('active')==='on' ? 1 : 0;
            $chapter->content = $validated['content'];
            $chapter->save();
            
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect( route('chapter_teacherShow', $id) )->with('status', "Something went wrong and we're sorry to say your changes could not be saved");    
        }
        return redirect(route('chapter_teacherShow', $id));
    }

    /**
     * Shows the confirmation page for deletion
     * 
     * @param int $id Chapter Id
     * @return \Illuminate\Http\Response
     */
    public function teacherConfirmDelete($id){
        $chapter = Chapter::find($id);
        if(empty($chapter)){
            return redirect(route('course_teacherIndex'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $chapter);
        $message = "<p>You have chosen to delete the following chapter: <strong>".$chapter->title."</strong></p>";
        $message .= "<ul><li>Course: ".$chapter->course->title."</li></ul>";
        $message .= "<p>Please be aware that this will remove all associated data, such as assignments, student attempts, marks, etc.</p>";
        $message .= "<p>Sure you want to delete ?</p>";
        return view('teacher.confirmDelete', [
            'route'=> route('chapter_teacherDelete', $id),
            'message'=>$message,
            'backRoute'=> route('chapter_teacherShow', $id),
            'resource'=>'chapter'
        ]);
    }

    /**
     * Soft Deleted the chapter
     * 
     * @param int $id Chapter Id
     * @return \Illuminate\Http\Response
     */
    public function teacherDelete($id){
        $chapter = Chapter::find($id);
        if(empty($chapter)){
            return redirect(route('course_teacherIndex'))->with("flash_modal", "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $chapter);
        
        //delete the course and the enrolments
        $deleted = $chapter->delete();
        if ($deleted){
            return redirect(route('course_teacherShow', $chapter->course->id))->with('success', 'Chapter Deleted');
        } else {
            return redirect(route('course_teacherShow', $chapter->course->id))->with('error', 'Chapter Could not be Deleted');
        }
    }

    /**
     * Toggle between chapter read and unread
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id Chapter Id
     * @return json 
     */
    public function studentRead(Request $request, int $id){
        if($request->ajax('')) {
            //find chapter
            $chapter = Chapter::find($id);
            $student = Student::find(Auth::id());
            if(empty($chapter) || empty($student)){
                return response()->json([
                    'success' => false, 
                ], 403);
            }

            //check student is enrolled in course
            if (!$student->courses->contains($chapter->course)){
                return response()->json([
                    'success' => false, 
                ], 403);
            }

            //update DB
            $enrolment = $chapter->course->enrolmentForAuth();
            if($chapter->isRead($student->id)){
                $enrolment->chaptersRead()->detach($chapter);
            } else {
                $enrolment->chaptersRead()->attach($chapter);
            }

            return response()->json([
                'success' => true, 
                'isRead' => $chapter->isRead($student->id)
            ], 200);

        }

    }
}
