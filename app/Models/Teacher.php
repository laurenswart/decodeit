<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Billable;
use function Illuminate\Events\queueable;
use Laravel\Cashier\Subscription;

class Teacher extends User
{
    use HasFactory, Billable, SoftDeletes;

    public function students(){
        return $this->belongsToMany(Student::class, 'teacher_student', 'teacher_id', 'student_id', 'id', 'id');
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'teacher_id', 'id' );
    }

    /**
     * Get all of chapters of teacher's courses
     */
    public function chapters(){
        return $this->hasManyThrough( Chapter::class, Course::class,);
    }

    /**
     * Get all of teacher's assignments
     */
    public function assignments(){
        return $this->hasManyThrough( Assignment::class, Course::class,);
    }
    
    /**
     * The courses create by this teacher
     */
    public function courses(){
        return $this->hasMany(Course::class, 'teacher_id', 'id' );
    }

    public function currentSubscription(){
        $subscription = Subscription::all()
            ->filter(function($item) {
                if (Carbon::now()->between($item->created_at, $item->ends_at)) {
                  return $item;
                }
              })
              ->where('teacher_id', $this->id)
              ->first();
        return $subscription;
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleId(1);
    }

    public function isOnFreeTrial(){
        return $this->currentSubscription() == null 
            && $this->created_at->diffInDays(Carbon::now()) <= 3;
    }

    public function currentSubscriptionPlan(){
        $plans = Plan::all();
        
        foreach($plans as $plan){
            if( $this->subscribed($plan->title)){
                return $plan;
            }
        }
        
        if($this->isOnFreeTrial()){
            return Plan::firstWhere('title', 'free');
        }
        return null;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(queueable(function ($customer) {
            if ($customer->hasStripeId()) {
                $customer->syncStripeCustomerDetails();
            }
        }));
    }

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function notifications(){
        $teacher = Teacher::find( Auth::id());
        $lastConnection = $teacher->last_connected;

        //dd($lastConnection);
        
        //assignments that have new submissions :Collection of assignmentIds
        $assignmentsWithNewSubmissions = StudentAssignment::
            select('assignment_id', DB::raw("min(submissions.created_at) as 'created_at'"))
            ->join('submissions', 'submissions.student_assignment_id', 'student_assignment.id')
            ->where('submissions.created_at', '>',$lastConnection)
            ->where('submissions.created_at', '=', DB::raw('submissions.updated_at'))
            ->groupBy('assignment_id')
            ->having(DB::raw('count(submissions.id)'), '>', 0)
            ->get();
        
       
        //assignments with submissions with question
        $assignmentsWithNewQuestions = StudentAssignment::
            select('assignment_id', DB::raw("min(submissions.created_at) as 'created_at'"))
            ->join('submissions', 'submissions.student_assignment_id', 'student_assignment.id')
            ->where('submissions.created_at', '>',$lastConnection)
            ->whereNotNull('submissions.question')
            ->whereNull('submissions.feedback')
            ->groupBy('assignment_id')
            ->having(DB::raw('count(submissions.id)'), '>', 0)
            ->get();
            
        //forum messages :Array
        //student is enroled in course and course is active
        $updatedForumCourseIds = Message::
                        select('course_id', DB::raw("min(forum_messages.created_at) as 'created_at'"), 'title')
                        ->join('courses', 'courses.id', 'forum_messages.course_id')
                        ->groupBy('course_id', 'title')
                        ->where('forum_messages.created_at', '>',$lastConnection)
                        ->get();
                        
        //dd($assignmentsWithNewSubmissions);
        

        //make a collection
        $models = [];
        
        foreach($assignmentsWithNewSubmissions as $studentAssignment){
            if(in_array($studentAssignment->assignment->course_id, $teacher->courses->pluck('id')->toArray())){
                $models[] = [
                    'icon'=>'<i class="fas fa-plus-square"></i>',
                    'route'=> route('assignment_teacherShow', $studentAssignment->assignment_id),
                    'text'=> 'New Submissions for ',
                    'resource' => ucfirst($studentAssignment->assignment->title),
                    'date'=> Carbon::parse($studentAssignment->created_at)
                ];
            }
        }
        foreach($assignmentsWithNewQuestions as $studentAssignment){
            if(in_array($studentAssignment->assignment->course_id, $teacher->courses->pluck('id')->toArray())){
                $models[] = [
                    'icon'=>'<i class="fas fa-plus-square"></i>',
                    'route'=> route('assignment_teacherShow', $studentAssignment->assignment_id),
                    'text'=> 'New Questions for ',
                    'resource' => ucfirst($studentAssignment->assignment->title),
                    'date'=> Carbon::parse($studentAssignment->created_at)
                ];
            }
        }
        foreach($updatedForumCourseIds as $updatedForumCourse){
            if(!in_array($updatedForumCourse['course_id'], $teacher->courses->pluck('id')->toArray())){
                continue;
            }
            $models[] = [
                'icon'=>'<i class="fas fa-comment-alt-dots"></i>',
                'route'=> route('message_teacherForum', $updatedForumCourse['course_id']),
                'text'=> 'New Messages in ',
                'resource' => ucfirst($updatedForumCourse['title']),
                'date'=> Carbon::parse($updatedForumCourse['created_at'])
            ];
        }
        
     
        
        
        //sort by creation date
        uasort($models, function($a, $b){
            if ($a['date'] == $b['date']) {
                return 0;
            }
            return ($a['date'] > $b['date']) ? -1 : 1;
        });
        return $models;
    }
}
