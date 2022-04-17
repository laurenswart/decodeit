<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Teacher;
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
     * Show form to create a new chapter
     *
     * @param int $id Course id
     * @return \Illuminate\Http\Response
     */
    public function teacherCreate(int $id){
        //$this->authorize('create', Course::class);
        //if no more available chapters in subscription
        $teacher = Teacher::find(Auth::id());
        $course = Course::find($id);
        $plan = $teacher->currentSubscriptionPlan();
         
        if ($plan === null){
            return redirect( route('course_teacherShow', $id)) 
                ->with('flash_modal', 'You do not have an active subscription. Please choose one of our subscription plans, or renew your previous subscription.');
        } else if (count($course->chapters) >=  $plan->nb_chapters){
            return redirect( route('course_teacherShow', $id))
                ->with('flash_modal', 'You have reached your subscription limit! Please upgrade to a subscription with a higher number of courses allowed, or delete one of your current courses.
                    Please be aware that this will remove all associated data, such as assignments, student attempts, etc.');
        }
        return view('teacher.chapter.create', ['course'=>$course]);
    }
}
