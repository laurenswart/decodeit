<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Student extends User
{
    use HasFactory, SoftDeletes;

    /**
     * This student's teachers
     */
    public function teachers(){
        return $this->belongsToMany(Student::class, 'teacher_student', 'student_id', 'teacher_id', 'id', 'id', );
    }

    /**
     * This student's enrolments
     */
    public function enrolments(){
        return $this->hasMany(Enrolment::class, 'student_id', 'id')->whereNull('enrolments.deleted_at');
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleId(2);
    }

    /**
     * The courses this student is enrolled to
     */
    public function courses(){
        return $this->belongsToMany(Course::class, 'enrolments', 'student_id', 'course_id', 'id', 'id')
            ->withPivot('final_mark', 'created_at', 'deleted_at')
            ->whereNull('enrolments.deleted_at')
            ->where('courses.is_active', true);
    }

    /**
     * The authenticated teacher's courses to which this student is enroled to
     */
    public function coursesForTeacher(){
        return $this->courses->where('teacher_id', Auth::id());
    }

    /**
     * Get all of the studentAssignments for the student.
     */
    public function studentAssignments(){
        return $this->hasManyThrough(StudentAssignment::class, Enrolment::class);
    }


    
    /**
     * Notification to display to this student on dashboard
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function notifications(){
        $student = Student::find( Auth::id());
        $lastConnection = $student->last_connected;

        //new enrolment :Eloquent\Collection
        //student is enroled in course and course is active
        $createdEnrolments = $student->courses()->wherePivot('created_at', '>',$lastConnection)->get();

        //created chapter :Eloquent\Collection
        //chapter is active, course id active, and student is enroled
        $createdChapters = Chapter::where('created_at', '>',$lastConnection)
            ->where('is_active', true)
            ->whereIn('course_id', $student->courses->pluck('id'))
            ->whereNotIn('course_id', $createdEnrolments->pluck('course_id')->toArray())
            ->get();
        
        //updated chapter content

        //create assignment:Eloquent\Collection
        //student is enroled in active course and related chapter is active
        $createdAssignments = Assignment::where('created_at', '>',$lastConnection)
            ->whereIn('course_id', $student->courses->pluck('id'))
            ->whereNotIn('course_id', $createdEnrolments->pluck('course_id')->toArray())
            ->get();
        
        
        //got feedback on submission :Eloquent\Collection
        //studentAssignment is for auth student
        $feedbackedSubmissions = Submission::where('feedback_at', '>',$lastConnection)
            ->whereIn('student_assignment_id', $student->studentAssignments->pluck('id'))->get();
        
        //got mark on student_assignment :Array
        //studentAssignment is for auth student
        $markedStudentAssignments = $student->studentAssignments->where('marked_at', '>',$lastConnection)
            ->whereIn('id',  $student->studentAssignments->pluck('id'))->all();
        

        //forum messages :Eloquent\Collection
        //student is enroled in course and course is active
        $updatedForumCourseIds = Message::
                        where('user_id', '!=', $this->id)
                        ->where('forum_messages.created_at', '>',$lastConnection)
                        ->select('course_id', DB::raw("min(forum_messages.created_at) as 'created_at'"), 'title')
                        ->join('courses', 'courses.id', 'forum_messages.course_id')
                        ->groupBy('course_id', 'title')
                        ->get();
        
        
        //got an enrolment final mark :Eloquent\Collection
        //student is enroled in course and course is active
        $markedEnrolments = $student->courses()->wherePivot('marked_at', '>',$lastConnection)->get();
        
        
        //new assignment notes :Array
        $assignmentIds = AssignmentNote::
                        groupBy('assignment_id')
                        ->where('assignment_notes.created_at', '>',$lastConnection)
                        ->pluck('assignment_id', DB::raw('min(assignment_notes.created_at) as created_at'))->all();
        $createdNoteAssignments = [];
        
        $courseIds = $student->courses->pluck('id')->toArray();
        foreach($assignmentIds as $created_at => $assignmentId){
            $assignment = Assignment::find($assignmentId);
            if(in_array($assignment->course_id, $courseIds) && $assignment->chapters[0]->is_active){
                $assignment->created_at = $created_at;
                $createdNoteAssignments[] = $assignment;
            }
        }

        

        //make a collection
        $models = [];
        foreach($createdChapters as $createdChapter){
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('chapter_studentShow', $createdChapter->id),
                'text'=> 'New Chapter in ',
                'resource' => ucfirst($createdChapter->course->title),
                'date'=> Carbon::parse($createdChapter->created_at)
            ];
        }
        foreach($createdAssignments as $createdAssignment){
            if($createdAssignment->chapters[0]->is_active){
                $models[] = [
                    'icon'=>'<i class="fas fa-plus-square"></i>',
                    'route'=> route('assignment_studentShow', $createdAssignment->id),
                    'text'=> 'New Assignment in ',
                    'resource' => ucfirst($createdAssignment->course->title),
                    'date'=> Carbon::parse($createdAssignment->created_at)
                ];
            }
        }
        foreach($feedbackedSubmissions as $feedbackedSubmission){
            if($feedbackedSubmission->studentAssignment->assignment->chapters[0]->is_active && $feedbackedSubmission->studentAssignment->assignment->course->is_active){
                $models[] = [
                    'icon'=>'<i class="fas fa-inbox-in"></i>',
                    'route'=> route('assignment_studentShow', $feedbackedSubmission->studentAssignment->assignment_id),
                    'text'=> 'Feedback Received for ',
                    'resource' => ucfirst($feedbackedSubmission->studentAssignment->assignment->title),
                    'date'=> Carbon::parse($feedbackedSubmission->feedback_at)
                ];
            }
        }
        foreach($markedStudentAssignments as $markedStudentAssignment){
            if($markedStudentAssignment->assignment->chapters[0]->is_active && $markedStudentAssignment->assignment->course->is_active){
                $models[] = [
                    'icon'=>'<i class="fas fa-inbox-in"></i>',
                    'route'=> route('assignment_studentShow', $markedStudentAssignment->assignment_id),
                    'text'=> 'Mark Received for ',
                    'resource' => ucfirst($markedStudentAssignment->assignment->title),
                    'date'=> Carbon::parse($markedStudentAssignment->marked_at)
                ];
            }
        }
        foreach($updatedForumCourseIds as $updatedForumCourse){
            if($student->courses->pluck('id')->contains($updatedForumCourse['course_id']) && !$createdEnrolments->pluck('course_id')->contains($updatedForumCourse['course_id'])){
                $models[] = [
                    'icon'=>'<i class="fas fa-comment-alt-dots"></i>',
                    'route'=> route('message_teacherForum', $updatedForumCourse['course_id']),
                    'text'=> 'New Messages in ',
                    'resource' => ucfirst($updatedForumCourse['title']),
                    'date'=> Carbon::parse($updatedForumCourse['created_at'])
                ];
            }
        }
        foreach($createdEnrolments as $createdEnrolmentCourse){
           
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('course_studentShow', $createdEnrolmentCourse->id),
                'text'=> 'New Course: ',
                'resource' => ucfirst($createdEnrolmentCourse->title),
                'date'=> Carbon::parse($createdEnrolmentCourse->pivot->created_at)
            ];
        }
        foreach($markedEnrolments as $markedEnrolment){
            $models[] = [
                'icon'=>'<i class="fas fa-inbox-in"></i>',
                'route'=> route('course_studentShow', $markedEnrolment->id),
                'text'=> 'Final Mark Received for ',
                'resource' => ucfirst($markedEnrolment->course->title),
                'date'=> Carbon::parse( $markedEnrolment->marked_at)
            ];
        }
        foreach($createdNoteAssignments as $createdNoteAssignment){
            if($createdEnrolments->pluck('course_id')->contains($createdNoteAssignment->assignment->course_id)) continue;
            $models[] = [
                'icon'=>'<i class="fas fa-comment-alt-dots"></i>',
                'route'=> route('assignment_studentShow', $createdNoteAssignment->id),
                'text'=> 'New Assignment Note for ',
                'resource' => ucfirst($createdNoteAssignment->title),
                'date'=> Carbon::parse($createdNoteAssignment->created_at)
            ];
        }
     
        
        

            uasort($models, function($a, $b){
                if ($a['date'] == $b['date']) {
                    return 0;
                }
                return ($a['date'] > $b['date']) ? -1 : 1;
            });
        return $models;
    }

}
